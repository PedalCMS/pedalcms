<?php

defined( 'ABSPATH' ) || exit;

$pedalcms_course_post = pedalcms_args_or_global( 'post', $args );

$pedalcms_defaults = [
	'context'         => $template,
	'add_permalink'   => false,
	'label_permalink' => pedalcms_get_label( 'course_info' ),
	'wrapper_class'   => 'course-actions',
	'actions'         => [],
];

$pedalcms_register_url = pedalcms_get_course_action_link( 'reg_search', $pedalcms_course_post );

if ( $pedalcms_register_url ) {
	$pedalcms_defaults['actions'][] = [
		'label' => pedalcms_get_label( 'register_action' ),
		'url'   => $pedalcms_register_url,
		'key'   => 'register',
	];
}

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

if ( $pedalcms_args['add_permalink'] ) {
	$pedalcms_permalink = true === $pedalcms_args['add_permalink'] ? get_permalink( $pedalcms_course_post ) : $pedalcms_args['add_permalink'];

	array_unshift(
		$pedalcms_args['actions'],
		[
			'label' => $pedalcms_args['label_permalink'],
			'url'   => $pedalcms_permalink,
			'key'   => 'course_info',
		]
	);
}

pedalcms_get_template_part( 'common/action-list', $pedalcms_args );
