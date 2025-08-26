<?php

$defaults = [
	'term'          => get_queried_object(),
	'link_image'    => true,
	'image_size'    => 'medium',
	'image_align'   => 'none',
	'wrapper_class' => '',
	'featured_img'  => null,
];

$args         = pdl_parse_template_args( $args, $defaults, $template );
$featured_img = $args['featured_img'];
$featured_term = $args['term'];

if ( ! $featured_img && $featured_term instanceof WP_Term ) {
	$featured_img = get_term_meta( $featured_term->term_id, 'featured_image', true );
}

$classes = [
	'featured-image',
	'term__image',
	$args['wrapper_class'],
	pdl_get_align_class( $args['image_align'] ),
];

$classes[] = ! $featured_img ? 'term__image--placeholder' : '';

$img = $featured_img ? wp_get_attachment_image( $featured_img, $args['image_size'] ) : '';

if ( $img ) {
	if ( $args['link_image'] ) {
		$img = sprintf(
			'<a href="%s">%s</a>',
			esc_url( get_term_link( $featured_term, $featured_term->taxonomy ) ),
			$img
		);
	}

	printf( '<div class="%s">%s</div>', esc_attr( implode( ' ', $classes ) ), wp_kses_post( $img ) );
}
