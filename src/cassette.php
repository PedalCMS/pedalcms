<?php
/**
 * CassetteCMF initialization.
 *
 * Bootstraps the CassetteCMF framework: registers custom field types and
 * sets up the plugin settings page with all six tabs.
 *
 * Replaces legacy src/acf.php and src/field-group-plugin.php.
 *
 * @package PedalCMS
 * @since 0.3.0
 */

namespace PedalCMS\Core;

use Pedalcms\CassetteCmf\CassetteCmf;
use Pedalcms\CassetteCmf\Field\Field_Factory;
use PedalCMS\Fields\Taxonomy_Field;
use PedalCMS\Fields\Relationship_Field;

// Register custom field types as early as possible.
add_action( 'init', __NAMESPACE__ . '\register_custom_field_types', 5 );

// Register settings page, CPTs, and taxonomy fields.
add_action( 'init', __NAMESPACE__ . '\cassette_init', 10 );

// Capture old relationship values before CassetteCMF saves (priority 5).
add_action( 'save_post', __NAMESPACE__ . '\capture_old_relationship_values', 5 );

// Sync taxonomy terms for CPT fields that use save_terms.
add_action( 'save_post', __NAMESPACE__ . '\sync_taxonomy_terms', 20 );

// Sync bidirectional CassetteCMF relationship fields after save (priority 25).
add_action( 'save_post', __NAMESPACE__ . '\sync_bidirectional_relationships', 25 );

// Flush rewrite rules after saving plugin settings.
add_action( 'cassette_cmf/settings/saved', __NAMESPACE__ . '\cassette_save_options', 20, 1 );
add_action( 'admin_init', __NAMESPACE__ . '\maybe_flush_rules' );

/**
 * Register custom CassetteCMF field types.
 *
 * @return void
 */
function register_custom_field_types(): void {
	Field_Factory::register_type( 'taxonomy', Taxonomy_Field::class );
	Field_Factory::register_type( 'relationship', Relationship_Field::class );
}

/**
 * Initialize CassetteCMF — register settings page and all CPT/taxonomy fields.
 *
 * @return void
 */
function cassette_init(): void {
	$settings_fields  = require Plugin::$path . '/src/fields-settings.php';
	$program_fields   = require Plugin::$path . '/src/fields-program.php';
	$course_fields    = require Plugin::$path . '/src/fields-course.php';
	$person_fields    = require Plugin::$path . '/src/fields-person.php';
	$taxonomy_fields  = require Plugin::$path . '/src/fields-taxonomies.php';

	CassetteCmf::register_from_array( [
		'cpts'           => [
			[ 'id' => 'pdl_program', 'fields' => $program_fields ],
			[ 'id' => 'pdl_course',  'fields' => $course_fields ],
			[ 'id' => 'pdl_person',  'fields' => $person_fields ],
		],
		'taxonomies'     => [
			[ 'id' => 'pdl_college',      'fields' => $taxonomy_fields['pdl_college'] ],
			[ 'id' => 'pdl_department',   'fields' => $taxonomy_fields['pdl_department'] ],
			[ 'id' => 'pdl_program_type', 'fields' => $taxonomy_fields['pdl_program_type'] ],
			[ 'id' => 'pdl_person_cat',   'fields' => $taxonomy_fields['pdl_person_cat'] ],
		],
		'settings_pages' => [
			[
				'id'          => 'options_pdl',
				'menu_slug'   => Plugin::$options_page_slug,
				'page_title'  => __( 'Pedal CMS Settings', 'pedalcms' ),
				'menu_title'  => _x( 'Settings', 'menu item title', 'pedalcms' ),
				'capability'  => 'manage_options',
				'parent_slug' => Plugin::$options_page_parent,
				'position'    => 100,
				'fields'      => $settings_fields,
			],
		],
	] );
}

/**
 * Sync taxonomy terms for CPT fields that use save_terms.
 *
 * Called on save_post after CassetteCMF has already stored field values in
 * post meta. Applies wp_set_post_terms() for each taxonomy-backed field that
 * requires bidirectional term assignment.
 *
 * @param int $post_id The post ID being saved.
 * @return void
 */
function sync_taxonomy_terms( int $post_id ): void {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	/** @var array<string, array<string, string>> $fields_map post_type => [ field_name => taxonomy ] */
	$fields_map = [
		'pdl_program' => [
			'college'          => 'pdl_college',
			'program_type'     => 'pdl_program_type',
			'instruction_mode' => 'pdl_instruct_mode',
		],
		'pdl_person'  => [
			'person_category' => 'pdl_person_cat',
			'college'         => 'pdl_college',
		],
	];

	$post_type = get_post_type( $post_id );
	$syncs     = $fields_map[ $post_type ] ?? [];

	foreach ( $syncs as $field_name => $taxonomy ) {
		$value    = get_post_meta( $post_id, $field_name, true );
		$term_ids = ( $value !== '' && $value !== false ) ? [ absint( $value ) ] : [];
		wp_set_post_terms( $post_id, $term_ids, $taxonomy );
	}
}

/**
 * Creates the `pdl_flush_rules` transient when saving the plugin settings page.
 *
 * @param string $page_id The saved settings page ID.
 * @return void
 */
function cassette_save_options( string $page_id ): void {
	if ( 'options_pdl' === $page_id ) {
		set_transient( 'pdl_flush_rules', true );
	}
}

/**
 * Flushes the rewrite rules when `pdl_flush_rules` transient is present.
 *
 * @return void
 */
function maybe_flush_rules(): void {
	if ( delete_transient( 'pdl_flush_rules' ) ) {
		flush_rewrite_rules();
	}
}

/**
 * Returns a map of post_type => [ field_name => reverse_field_name ] pairs
 * that must be kept in bidirectional sync.
 *
 * @return array<string, array<string, string>>
 */
function get_bidirectional_pairs(): array {
	return [
		'pdl_program' => [ 'related_program_careers'  => 'related_career_programs' ],
		'pdl_career'  => [ 'related_career_programs'   => 'related_program_careers' ],
		'pdl_course'  => [ 'related_course_personnel'  => 'related_person_courses' ],
		'pdl_person'  => [ 'related_person_courses'    => 'related_course_personnel' ],
	];
}

/**
 * Saves the current (pre-save) relationship values before CassetteCMF
 * overwrites them, so sync_bidirectional_relationships() can diff them.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function capture_old_relationship_values( int $post_id ): void {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	$pairs     = get_bidirectional_pairs();
	$post_type = get_post_type( $post_id );

	if ( ! isset( $pairs[ $post_type ] ) ) {
		return;
	}

	foreach ( $pairs[ $post_type ] as $field_name => $_ ) {
		$GLOBALS['pdl_bidir_old'][ $post_id ][ $field_name ] =
			array_map( 'intval', (array) ( get_post_meta( $post_id, $field_name, true ) ?: [] ) );
	}
}

/**
 * Keeps bidirectional relationship fields in sync after CassetteCMF saves.
 *
 * Runs at priority 25 — after CassetteCMF (priority 10) and taxonomy sync
 * (priority 20) have both completed.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function sync_bidirectional_relationships( int $post_id ): void {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Prevent re-entry when we update related posts below.
	if ( ! empty( $GLOBALS['pdl_is_syncing_bidir'] ) ) {
		return;
	}

	$pairs     = get_bidirectional_pairs();
	$post_type = get_post_type( $post_id );

	if ( ! isset( $pairs[ $post_type ] ) ) {
		return;
	}

	$GLOBALS['pdl_is_syncing_bidir'] = true;

	foreach ( $pairs[ $post_type ] as $field_name => $rel_field_name ) {
		$old_ids = $GLOBALS['pdl_bidir_old'][ $post_id ][ $field_name ] ?? [];
		$new_ids = array_map( 'intval', (array) ( get_post_meta( $post_id, $field_name, true ) ?: [] ) );

		$add_to      = array_diff( $new_ids, $old_ids );
		$remove_from = array_diff( $old_ids, $new_ids );

		foreach ( $add_to as $related_id ) {
			$existing = array_map( 'intval', (array) ( get_post_meta( $related_id, $rel_field_name, true ) ?: [] ) );
			if ( ! in_array( $post_id, $existing, true ) ) {
				$existing[] = $post_id;
				update_post_meta( $related_id, $rel_field_name, $existing );
			}
		}

		foreach ( $remove_from as $related_id ) {
			$existing = array_map( 'intval', (array) ( get_post_meta( $related_id, $rel_field_name, true ) ?: [] ) );
			$existing = array_values( array_filter( $existing, static fn( int $id ) => $id !== $post_id ) );
			update_post_meta( $related_id, $rel_field_name, $existing );
		}
	}

	unset( $GLOBALS['pdl_is_syncing_bidir'] );
}

require __DIR__ . '/polyfills.php';
