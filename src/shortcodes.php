<?php

namespace PedalCMS\Core;

defined( 'ABSPATH' ) || exit;

add_action( 'init', __NAMESPACE__ . '\add_shortcodes' );

/**
 * Registered shortcodes for the plugin.
 *
 * @since 0.1.0
 *
 * @return void
 */
function add_shortcodes() {
	add_shortcode( 'pedalcms_terms_grid', __NAMESPACE__ . '\render_terms_grid' );
}

/**
 * Renders the `pedalcms_terms_grid` shortcode.
 *
 * @since 0.1.0
 *
 * @param array $atts
 * @return void
 */
function render_terms_grid( $atts ) {
	$atts = shortcode_atts(
		[
			'tax'                => null,
			'title_tag'          => 'h2',
			'show_image'         => true,
			'show_description'   => true,
			'show_num_posts'     => true,
			'show_posts_link'    => true,
			'label_posts'        => 'Posts',
			'label_posts_single' => 'Post',
			'label_sr_text'      => 'in %',
			'posts_link_prefix'  => 'Explore',
			'wrapper_class'      => '',
			'columns'            => 3,
			'image_size'         => 'medium',

		],
		$atts,
		'pedalcms_terms_grid'
	);

	if ( ! $atts['tax'] ) {
		return __( 'You must supply a taxonomy via the tax attribute (e.g. tax="pedalcms_program_type").', 'pedal-cms' );
	}

	$atts['terms'] = get_terms( [ 'taxonomy' => $atts['tax'] ] );

	ob_start();
	pedalcms_get_template_part( 'common/terms-grid', $atts );

	return ob_get_clean();
}
