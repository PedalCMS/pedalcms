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
		'pdl-global',
		Plugin::$url . $global,
		[],
		filemtime( Plugin::$path . $global )
	);

	$base = '/assets/css/base.min.css';
	wp_register_style(
		'pdl-programs-base',
		Plugin::$url . $base,
		[ 'pdl-global' ],
		filemtime( Plugin::$path . $base )
	);

	$global_full = '/assets/css/global-full.min.css';
	wp_register_style(
		'pdl-global-full',
		Plugin::$url . $global_full,
		[ 'pdl-global' ],
		filemtime( Plugin::$path . $global_full )
	);

	$full = '/assets/css/full.min.css';
	wp_register_style(
		'pdl-programs-full',
		Plugin::$url . $full,
		[ 'pdl-global', 'pdl-programs-base' ],
		filemtime( Plugin::$path . $full )
	);

	$terms_grid = '/assets/css/terms-grid.min.css';
	wp_register_style(
		'pdl-terms-grid',
		Plugin::$url . $terms_grid,
		[ 'pdl-global' ],
		filemtime( Plugin::$path . $terms_grid )
	);

	$global = '/assets/js/global.min.js';
	wp_register_script(
		'pdl-global',
		Plugin::$url . $global,
		[],
		filemtime( Plugin::$path . $global ),
		true
	);
}

/**
 * Enqueues frontend assets.
 *
 * @return void
 */
function enqueue_assets() {
	$presentation_mode = Plugin::get_option( 'presentation_mode' );

	if ( ! $presentation_mode ) {
		$presentation_mode = 'base';
	}

	if ( pdl_is_active_subpage( 'careers' ) && 'none' !== $presentation_mode ) {
		wp_enqueue_style( 'pdl-careers-base' );
	}

	if ( ! is_admin() ) {
		if ( 'none' !== $presentation_mode ) {
			wp_enqueue_style( 'pdl-global' );
		}

		if ( 'full' === $presentation_mode ) {
			wp_enqueue_style( 'pdl-global-full' );
		}
	}

	if ( ! is_admin() && 'none' !== $presentation_mode ) {
		if ( is_singular() ) {
			$post = get_post();

			if ( strpos( $post->post_content, '[pdl_terms_grid ' ) ) {
				wp_enqueue_style( 'pdl-terms-grid' );
			}
		}
	}

	$is_plugin_content =
		is_singular( Plugin::post_types() ) ||
		is_post_type_archive( Plugin::post_types() ) ||
		is_tax( Plugin::taxonomies() );

	if ( ! is_admin() && $is_plugin_content ) {
		if ( 'none' !== $presentation_mode ) {
			wp_enqueue_style( 'pdl-programs-base' );
		}

		if ( 'full' === $presentation_mode ) {
			wp_enqueue_style( 'pdl-programs-full' );
		}
	}

	if ( ! is_admin() ) {
		wp_enqueue_script( 'pdl-global' );
	}
}

/**
 * Enqueues WP Admin assets.
 *
 * @return void
 */
function admin_enqueue_assets() {
	global $pagenow;

	$post_type = get_post_type();
	$is_post_edit =
		in_array( $pagenow, [ 'post.php', 'post-new.php' ], true ) &&
		in_array( $post_type, Plugin::post_types(), true );
	$pdl_css = '/admin/css/pdl-admin.css';

	wp_enqueue_style(
		'pdl-admin',
		Plugin::$url . $pdl_css,
		[],
		filemtime( Plugin::$path . $pdl_css )
	);

	$pdl_css = '/admin/css/settings-page.css';
	wp_enqueue_style(
		'pdl-settings',
		Plugin::$url . $pdl_css,
		[],
		filemtime( Plugin::$path . $pdl_css )
	);

	$pdl_css = '/admin/css/field-fancy-toggle.css';
	wp_enqueue_style(
		'pdl-toggle',
		Plugin::$url . $pdl_css,
		[],
		filemtime( Plugin::$path . $pdl_css )
	);

	if ($is_post_edit) {
		if ($post_type === Program::POST_TYPE) {
			$pdl_css = '/admin/css/metabox-tabs.css';

			wp_enqueue_style(
				'pdl-metabox-tabs',
				Plugin::$url . $pdl_css,
				[],
				filemtime( Plugin::$path . $pdl_css )
			);

			$pdl_css = '/admin/css/program-fields.css';

			wp_enqueue_style(
				'pdl-program-fields',
				Plugin::$url . $pdl_css,
				[],
				filemtime( Plugin::$path . $pdl_css )
			);

			wp_enqueue_script(
				'tabby',
				'https://cdnjs.cloudflare.com/ajax/libs/tabby/12.0.3/js/tabby.polyfills.js',
				[],
				'12.0.3',
				true
			);
		}

		if ( Department::depends_on_college() ) {
			$pdl_acf = '/admin/js/pdl-acf.min.js';

			wp_enqueue_script(
				'pdl-acf',
				Plugin::$url . $pdl_acf,
				[ 'acf' ],
				filemtime( Plugin::$path . $pdl_acf ),
				true
			);

			$pdl_acf_data = [
				'ajax_url'        => admin_url( 'admin-ajax.php' ),
				'nonce'           => wp_create_nonce( 'pdl_acf_data' ),
				'label_not_found' => __( 'No departments found', 'pedalcms' ),
			];

			wp_localize_script( 'pdl-acf', 'pdlACFData', $pdl_acf_data );
		}
	}

}
