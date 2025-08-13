<?php
/**
 * A template for displaying the Person archive search and filter form.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 *
 */

defined( 'ABSPATH' ) || exit;

$args = [
	'post_type'           => 'pdl_person',
	'break_filters_after' => 2,
	'filters'             => [
		'keyword',
		'person-cat',
		'college',
		'department',
	],
];

pdl_get_template_part( 'common/filters', $args );
