<?php

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'term'          => get_queried_object(),
	'link_image'    => true,
	'image_size'    => 'medium',
	'image_align'   => 'none',
	'wrapper_class' => '',
	'featured_img'  => null,
];

$pedalcms_args          = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );
$pedalcms_featured_img  = $pedalcms_args['featured_img'];
$pedalcms_featured_term = $pedalcms_args['term'];

if ( ! $pedalcms_featured_img && $pedalcms_featured_term instanceof WP_Term ) {
	$pedalcms_featured_img = get_term_meta( $pedalcms_featured_term->term_id, 'pedalcms_featured_image', true );
}

$pedalcms_classes = [
	'featured-image',
	'term__image',
	$pedalcms_args['wrapper_class'],
	pedalcms_get_align_class( $pedalcms_args['image_align'] ),
];

$pedalcms_classes[] = ! $pedalcms_featured_img ? 'term__image--placeholder' : '';

$pedalcms_img = $pedalcms_featured_img ? wp_get_attachment_image( $pedalcms_featured_img, $pedalcms_args['image_size'] ) : '';

if ( $pedalcms_img ) {
	if ( $pedalcms_args['link_image'] ) {
		$pedalcms_img = sprintf(
			'<a href="%s">%s</a>',
			esc_url( get_term_link( $pedalcms_featured_term, $pedalcms_featured_term->taxonomy ) ),
			$pedalcms_img
		);
	}

	printf( '<div class="%s">%s</div>', esc_attr( implode( ' ', $pedalcms_classes ) ), wp_kses_post( $pedalcms_img ) );
}
