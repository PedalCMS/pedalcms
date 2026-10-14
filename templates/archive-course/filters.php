<?php
/**
 * A template for displaying the Course archive search and filter form.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 *
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_args = [
	'post_type' => 'pedalcms_course',
	'filters'   => [
		'keyword',
		'session',
		'subject',
		'instruct-mode',
		'college',
		'department',
	],
];

pedalcms_get_template_part( 'common/filters', $pedalcms_args );
