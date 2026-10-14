<?php
/**
 * The template for displaying Program action buttons.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_program_post = pedalcms_args_or_global( 'post', $args );

$pedalcms_defaults = [
	'context'         => $template,
	'add_permalink'   => false,
	'label_permalink' => pedalcms_get_label( 'program_details' ),
	'actions'         => [
		[
			'label' => pedalcms_get_label( 'apply_now_action' ),
			'url'   => pedalcms_get_action_link( 'apply_now', $pedalcms_program_post ),
			'key'   => 'apply_now',
		],
		[
			'label' => pedalcms_get_label( 'request_info_action' ),
			'url'   => pedalcms_get_action_link( 'request_info', $pedalcms_program_post ),
			'key'   => 'request_info',
		],
	],
	'wrapper_class'   => 'program-actions',
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

if ( $pedalcms_args['add_permalink'] ) {
	$pedalcms_permalink = true === $pedalcms_args['add_permalink'] ? get_permalink( $pedalcms_program_post ) : $pedalcms_args['add_permalink'];

	array_unshift(
		$pedalcms_args['actions'],
		[
			'label' => $pedalcms_args['label_permalink'],
			'url'   => $pedalcms_permalink,
			'key'   => 'program_details',
		]
	);
}

pedalcms_get_template_part( 'common/action-list', $pedalcms_args );
