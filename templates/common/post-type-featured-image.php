<?php

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'post_type'     => get_post_type(),
	'image_size'    => 'medium',
	'image_align'   => 'right',
	'wrapper_class' => '',
	'featured_img'  => null,
];

$pedalcms_args         = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );
$pedalcms_featured_img = $pedalcms_args['featured_img'];

$pedalcms_classes = [
	'featured-image',
	'post-type-image',
	$pedalcms_args['wrapper_class'],
	pedalcms_get_align_class( $pedalcms_args['image_align'] ),
];

$pedalcms_classes[] = $pedalcms_featured_img ? 'post-type-image--placeholder' : '';

$pedalcms_img = $pedalcms_featured_img ? wp_get_attachment_image( $pedalcms_featured_img, $pedalcms_args['image_size'] ) : '';

printf( '<div class="%s">%s</div>', esc_attr( implode( ' ', $pedalcms_classes ) ), wp_kses_post( $pedalcms_img ) );
