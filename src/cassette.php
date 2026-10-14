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

use PedalCMS\CassetteCMF\CassetteCMF;
use PedalCMS\CassetteCMF\Field\Field_Factory;
use PedalCMS\Fields\Taxonomy_Field;
use PedalCMS\Fields\Relationship_Field;
use PedalCMS\Fields\Conditional_Checkbox_Field;
use PedalCMS\Fields\Conditional_Number_Field;

defined( 'ABSPATH' ) || exit;

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
add_filter( 'cassette_cmf_before_save_field', __NAMESPACE__ . '\cassette_save_options', 20, 3 );
add_action( 'admin_init', __NAMESPACE__ . '\maybe_flush_rules' );

// CassetteCMF redirects to admin.php?page={page_id} after save, but our page is
// registered under a different menu_slug. Rewrite to the correct slug.
add_filter( 'wp_redirect', __NAMESPACE__ . '\fix_settings_redirect', 10, 1 );

/**
 * Register custom CassetteCMF field types.
 *
 * @return void
 */
function register_custom_field_types(): void {
	Field_Factory::register_type( 'taxonomy', Taxonomy_Field::class );
	Field_Factory::register_type( 'relationship', Relationship_Field::class );
	Field_Factory::register_type( 'conditional_checkbox', Conditional_Checkbox_Field::class );
	Field_Factory::register_type( 'conditional_number', Conditional_Number_Field::class );
}

/**
 * Initialize CassetteCMF — register settings page and all CPT/taxonomy fields.
 *
 * @return void
 */
function cassette_init(): void {
	$settings_fields = require Plugin::$path . '/src/fields-settings.php';
	$program_fields  = require Plugin::$path . '/src/fields-program.php';
	$course_fields   = require Plugin::$path . '/src/fields-course.php';
	$person_fields   = require Plugin::$path . '/src/fields-person.php';
	$taxonomy_fields = require Plugin::$path . '/src/fields-taxonomies.php';

	$config = [
		'cpts'           => apply_filters(
			'pedalcms/cassette/cpts',
			[
				[
					'id'     => 'pedalcms_program',
					'fields' => $program_fields,
				],
				[
					'id'     => 'pedalcms_course',
					'fields' => $course_fields,
				],
				[
					'id'     => 'pedalcms_person',
					'fields' => $person_fields,
				],
			]
		),
		'taxonomies'     => apply_filters(
			'pedalcms/cassette/taxonomies',
			[
				[
					'id'     => 'pedalcms_college',
					'fields' => $taxonomy_fields['pedalcms_college'],
				],
				[
					'id'     => 'pedalcms_department',
					'fields' => $taxonomy_fields['pedalcms_department'],
				],
				[
					'id'     => 'pedalcms_program_type',
					'fields' => $taxonomy_fields['pedalcms_program_type'],
				],
				[
					'id'     => 'pedalcms_person_cat',
					'fields' => $taxonomy_fields['pedalcms_person_cat'],
				],
			]
		),
		'settings_pages' => [],
	];

	/*
	 * Deployments that lock configuration down can disable the settings UI.
	 * Only the admin page is skipped here; stored settings remain readable
	 * through Plugin::get_option() and writable programmatically.
	 */
	if ( Plugin::settings_ui_enabled() ) {
		$config['settings_pages'] = apply_filters(
			'pedalcms/cassette/settings_pages',
			[
				[
					'id'          => 'pedalcms',
					'menu_slug'   => Plugin::$options_page_slug,
					'page_title'  => __( 'Pedal CMS Settings', 'pedal-cms' ),
					'menu_title'  => _x( 'Settings', 'menu item title', 'pedal-cms' ),
					'capability'  => 'manage_options',
					'parent_slug' => Plugin::$options_page_parent,
					'position'    => 100,
					'fields'      => $settings_fields,
				],
			]
		);
	}

	CassetteCMF::register_from_array(
		apply_filters( 'pedalcms/cassette/config', $config )
	);
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
		'pedalcms_program' => [
			'pedalcms_college'          => 'pedalcms_college',
			'pedalcms_program_type'     => 'pedalcms_program_type',
			'pedalcms_instruction_mode' => 'pedalcms_instruct_mode',
		],
		'pedalcms_person'  => [
			'pedalcms_person_category' => 'pedalcms_person_cat',
			'pedalcms_college'         => 'pedalcms_college',
		],
	];

	$post_type = get_post_type( $post_id );
	$syncs     = $fields_map[ $post_type ] ?? [];

	foreach ( $syncs as $field_name => $taxonomy ) {
		$value    = get_post_meta( $post_id, $field_name, true );
		$term_ids = ( '' !== $value && false !== $value ) ? [ absint( $value ) ] : [];
		wp_set_post_terms( $post_id, $term_ids, $taxonomy );
	}
}

/**
 * Creates the `pedalcms_flush_rules` transient when saving the plugin settings page.
 *
	* Called on filter: `cassette_cmf_before_save_field`
	*
	* @param mixed  $value The field value (unchanged).
	* @param string $field_name The field being saved.
	* @param string $context The save context (settings page ID or post type).
	* @return mixed The original field value.
 */
function cassette_save_options( $value, string $field_name, string $context ) {
	if ( 'pedalcms' === $context || Plugin::$options_page_slug === $context ) {
		set_transient( 'pedalcms_flush_rules', true );
	}

	return $value;
}

/**
 * Flushes the rewrite rules when `pedalcms_flush_rules` transient is present.
 *
 * @return void
 */
function maybe_flush_rules(): void {
	if ( delete_transient( 'pedalcms_flush_rules' ) ) {
		flush_rewrite_rules();
	}
}

/**
 * Rewrites CassetteCMF's post-save redirect to use the correct menu_slug.
 *
 * CassetteCMF redirects to admin.php?page={page_id} ('pedalcms') but the
 * settings page is registered under menu_slug 'pedalcms-settings'.
 *
 * @param string $location Redirect URL.
 * @return string
 */
function fix_settings_redirect( string $location ): string {
	// Only the bare page id; leave an already-correct `page=pedalcms-settings` untouched.
	return preg_replace( '/page=pedalcms(?![\w-])/', 'page=' . Plugin::$options_page_slug, $location ) ?? $location;
}

/**
 * Returns a map of post_type => [ field_name => reverse_field_name ] pairs
 * that must be kept in bidirectional sync.
 *
 * @return array<string, array<string, string>>
 */
function get_bidirectional_pairs(): array {
	return [
		'pedalcms_program' => [ 'pedalcms_related_program_careers' => 'pedalcms_related_career_programs' ],
		'pedalcms_career'  => [ 'pedalcms_related_career_programs' => 'pedalcms_related_program_careers' ],
		'pedalcms_course'  => [ 'pedalcms_related_course_personnel' => 'pedalcms_related_person_courses' ],
		'pedalcms_person'  => [ 'pedalcms_related_person_courses' => 'pedalcms_related_course_personnel' ],
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
		$GLOBALS['pedalcms_bidir_old'][ $post_id ][ $field_name ] =
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
	if ( ! empty( $GLOBALS['pedalcms_is_syncing_bidir'] ) ) {
		return;
	}

	$pairs     = get_bidirectional_pairs();
	$post_type = get_post_type( $post_id );

	if ( ! isset( $pairs[ $post_type ] ) ) {
		return;
	}

	$GLOBALS['pedalcms_is_syncing_bidir'] = true;

	foreach ( $pairs[ $post_type ] as $field_name => $rel_field_name ) {
		$old_ids = $GLOBALS['pedalcms_bidir_old'][ $post_id ][ $field_name ] ?? [];
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

	unset( $GLOBALS['pedalcms_is_syncing_bidir'] );
}
