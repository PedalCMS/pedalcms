<?php
/**
 * A template for displaying the Person archive search and filter form.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 *
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_args = [
	'post_type' => 'pedalcms_person',
	'filters'   => [
		'keyword',
		'person-cat',
		'college',
		'department',
	],
];

pedalcms_get_template_part( 'common/filters', $pedalcms_args );
