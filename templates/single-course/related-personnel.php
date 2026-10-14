<?php
/**
 * The template for displaying a list of people who teach a Course.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_course_post = pedalcms_args_or_global( 'post', $args );

$pedalcms_defaults = [
	'h_level'           => 2,
	'style'             => 'full',
	'label_instructors' => pedalcms_get_label( 'instructors' ),
	'personnel'         => pedalcms_get_field( 'pedalcms_related_course_personnel', $pedalcms_course_post ),
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

$pedalcms_style = in_array( $pedalcms_args['style'], [ 'full','links' ], true ) ? $pedalcms_args['style'] : $pedalcms_defaults['style'];
$pedalcms_h_tag = pedalcms_get_heading_tag( $pedalcms_args['h_level'] );

if ( ! empty( $pedalcms_args['personnel'] ) ) :
	?>
<div class="course-personnel">
	<?php
	printf( '<%s>%s</%s>', esc_html( $pedalcms_h_tag ), esc_html( $pedalcms_args['label_instructors'] ), esc_html( $pedalcms_h_tag ) );

	if ( 'full' === $pedalcms_style ) :
		pedalcms_get_template_part(
			'archive-person/person-list',
			[
				'people'            => $pedalcms_args['personnel'],
				'layout'            => 'list',
				'show_contact_info' => false,
				'h_level'           => 3,
				'img_size'          => 'thumbnail',
				'context'           => $template,
			]
		);
	elseif ( 'links' === $pedalcms_style ) :
		pedalcms_get_template_part( 'common/posts-links', [ 'posts' => $pedalcms_args['personnel'] ] );
	endif;
	?>
</div>
	<?php
endif;
