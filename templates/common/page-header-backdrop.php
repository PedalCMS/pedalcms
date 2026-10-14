<?php

defined( 'ABSPATH' ) || exit;

$pedalcms_header_post = pedalcms_args_or_global( 'post', $args );

$pedalcms_defaults = [
	'attachment_id'    => 0,
	'show_backdrop'    => false,
	'backdrop_size'    => 'large',
	'fallback_to_post' => true,
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

if ( empty( $pedalcms_args['attachment_id'] ) && $pedalcms_args['fallback_to_post'] ) {
	$pedalcms_args['attachment_id'] = get_post_thumbnail_id( $pedalcms_header_post );
}

if ( $pedalcms_args['show_backdrop'] && $pedalcms_args['attachment_id'] ) :
	printf(
		'<div class="page-header__backdrop">%s</div>',
		wp_get_attachment_image(
			$pedalcms_args['attachment_id'],
			$pedalcms_args['backdrop_size'],
			false,
			[
				'alt'   => '',
				'title' => '',
			]
		)
	);
endif;
