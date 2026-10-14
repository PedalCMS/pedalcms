<?php
/**
 * The template for displaying the featured image of a post.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_featured_post = pedalcms_args_or_global( 'post', $args );

$pedalcms_defaults = [
	'show_image'             => true,
	'link_image'             => false,
	'image_size'             => 'medium',
	'image_align'            => 'right',
	'image_wrapper_class'    => '',
	'image_attributes'       => '',
	'fallback_attachment_id' => '',
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

$pedalcms_align_class = in_array( $pedalcms_args['image_align'], [ 'left','right','center','none' ], true )
	? $pedalcms_args['image_align']
	: 'right';

$pedalcms_align_class = 'align' . $pedalcms_align_class;
$pedalcms_classes     = [
	'featured-image',
	$pedalcms_align_class,
	esc_attr( $pedalcms_args['image_wrapper_class'] ),
];

$pedalcms_show_image = $pedalcms_args['show_image'] && (
	has_post_thumbnail( $pedalcms_featured_post ) ||
	! empty( $pedalcms_args['fallback_attachment_id'] )
);

if ( $pedalcms_show_image ) :
	$pedalcms_image = pedalcms_post_thumbnail_or_fallback(
		$pedalcms_featured_post,
		$pedalcms_args['fallback_attachment_id'],
		$pedalcms_args['image_size'],
		$pedalcms_args['image_attributes']
	);

	if ( $pedalcms_args['link_image'] ) :
		printf(
			'<div class="%s"><a href="%s">%s</a></div>',
			esc_attr( implode( ' ', $pedalcms_classes ) ),
			esc_url( get_the_permalink( $pedalcms_featured_post ) ),
			wp_kses_post( $pedalcms_image )
		);
	else :
		printf(
			'<div class="%s">%s</div>',
			esc_attr( implode( ' ', $pedalcms_classes ) ),
			wp_kses_post( $pedalcms_image )
		);
	endif;
endif;
