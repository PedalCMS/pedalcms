<?php
/**
 * A template for displaying the Program archive search and filter form.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 *
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'post_type'           => 'pedalcms_program',
	'break_filters_after' => 0,
	'filters'             => [
		'keyword',
		'program-type',
		'instruct-mode',
		'college',
		'department',
	],
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

pedalcms_get_template_part( 'common/filters', $pedalcms_args );
