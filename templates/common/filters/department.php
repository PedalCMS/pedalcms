<?php
/**
 * Displays a Department taxonomy dropdown filter.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$defaults = [
	'taxonomy'  => 'pdl_department',
	'query_var' => 'dept',
];

$args = pdl_parse_template_args( $args, $defaults, $template );

pdl_get_template_part( 'common/filters/taxonomy', $args );
