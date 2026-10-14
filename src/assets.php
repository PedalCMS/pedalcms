<?php
/**
 * Asset management.
 *
 * @package PedalCMS
 * @since 0.1.0
 */

namespace PedalCMS\Core;

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\register_assets', 0 );
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets' );
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\admin_enqueue_assets' );

/**
 * Registers frontend assets.
 *
 * @return void
 */
function register_assets() {
	$global = '/assets/css/global.min.css';
	wp_register_style(
		'pedalcms-global',
		Plugin::$url . $global,
		[],
		filemtime( Plugin::$path . $global )
	);

	$base = '/assets/css/base.min.css';
	wp_register_style(
		'pedalcms-programs-base',
		Plugin::$url . $base,
		[ 'pedalcms-global' ],
		filemtime( Plugin::$path . $base )
	);

	$global_full = '/assets/css/global-full.min.css';
	wp_register_style(
		'pedalcms-global-full',
		Plugin::$url . $global_full,
		[ 'pedalcms-global' ],
		filemtime( Plugin::$path . $global_full )
	);

	$full = '/assets/css/full.min.css';
	wp_register_style(
		'pedalcms-programs-full',
		Plugin::$url . $full,
		[ 'pedalcms-global', 'pedalcms-programs-base' ],
		filemtime( Plugin::$path . $full )
	);

	$terms_grid = '/assets/css/terms-grid.min.css';
	wp_register_style(
		'pedalcms-terms-grid',
		Plugin::$url . $terms_grid,
		[ 'pedalcms-global' ],
		filemtime( Plugin::$path . $terms_grid )
	);

	$global = '/assets/js/global.min.js';
	wp_register_script(
		'pedalcms-global',
		Plugin::$url . $global,
		[],
		filemtime( Plugin::$path . $global ),
		true
	);

	wp_register_style( 'pedalcms-options', false, [], PEDALCMS_VERSION );
}

/**
 * Enqueues frontend assets.
 *
 * @return void
 */
function enqueue_assets() {
	$presentation_mode = Plugin::get_option( 'presentation_mode', 'full' );

	if ( ! $presentation_mode ) {
		$presentation_mode = 'base';
	}

	if ( pedalcms_is_active_subpage( 'careers' ) && 'none' !== $presentation_mode ) {
		wp_enqueue_style( 'pedalcms-careers-base' );
	}

	if ( ! is_admin() ) {
		if ( 'none' !== $presentation_mode ) {
			wp_enqueue_style( 'pedalcms-global' );
		}

		if ( 'full' === $presentation_mode ) {
			wp_enqueue_style( 'pedalcms-global-full' );
		}
	}

	if ( ! is_admin() && 'none' !== $presentation_mode ) {
		if ( is_singular() ) {
			$post = get_post();

			if ( strpos( $post->post_content, '[pedalcms_terms_grid ' ) ) {
				wp_enqueue_style( 'pedalcms-terms-grid' );
			}
		}
	}

	$is_plugin_content =
		is_singular( Plugin::post_types() ) ||
		is_post_type_archive( Plugin::post_types() ) ||
		is_tax( Plugin::taxonomies() );

	if ( ! is_admin() && $is_plugin_content ) {
		if ( 'none' !== $presentation_mode ) {
			wp_enqueue_style( 'pedalcms-programs-base' );
		}

		if ( 'full' === $presentation_mode ) {
			wp_enqueue_style( 'pedalcms-programs-full' );
		}
	}

	if ( ! is_admin() ) {
		$options_css = get_options_inline_css();

		if ( $options_css ) {
			wp_enqueue_style( 'pedalcms-options' );
			wp_add_inline_style( 'pedalcms-options', $options_css );
		}

		wp_enqueue_script( 'pedalcms-global' );
	}
}

/**
 * Enqueues WP Admin assets.
 *
 * @return void
 */
function admin_enqueue_assets() {
	global $pagenow;

	$post_type    = get_post_type();
	$is_post_edit =
		in_array( $pagenow, [ 'post.php', 'post-new.php' ], true ) &&
		in_array( $post_type, Plugin::post_types(), true );
	$pedalcms_css = '/admin/css/pdl-admin.css';

	wp_enqueue_style(
		'pedalcms-admin',
		Plugin::$url . $pedalcms_css,
		[],
		filemtime( Plugin::$path . $pedalcms_css )
	);

	$pedalcms_css = '/admin/css/settings-page.css';
	wp_enqueue_style(
		'pedalcms-settings',
		Plugin::$url . $pedalcms_css,
		[],
		filemtime( Plugin::$path . $pedalcms_css )
	);

	$pedalcms_css = '/admin/css/field-fancy-toggle.css';
	wp_enqueue_style(
		'pedalcms-toggle',
		Plugin::$url . $pedalcms_css,
		[],
		filemtime( Plugin::$path . $pedalcms_css )
	);

	if ( $is_post_edit ) {
		if ( Department::depends_on_college() ) {
			$pedalcms_acf = '/admin/js/pdl-acf.min.js';

			wp_enqueue_script(
				'pedalcms-department',
				Plugin::$url . $pedalcms_acf,
				[],
				filemtime( Plugin::$path . $pedalcms_acf ),
				true
			);

			$pedalcms_acf_data = [
				'ajax_url'        => admin_url( 'admin-ajax.php' ),
				'nonce'           => wp_create_nonce( 'pedalcms_admin_data' ),
				'label_not_found' => __( 'No departments found', 'pedal-cms' ),
			];

			wp_localize_script( 'pedalcms-department', 'pedalcmsACFData', $pedalcms_acf_data );
		}

		$pedalcms_conditional = '/admin/js/pdl-conditional.min.js';

		wp_enqueue_script(
			'pedalcms-conditional',
			Plugin::$url . $pedalcms_conditional,
			[ 'jquery' ],
			filemtime( Plugin::$path . $pedalcms_conditional ),
			true
		);
	}
}
