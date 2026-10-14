<?php
/**
 * Displays an Instruction Mode taxonomy dropdown filter.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'taxonomy'  => 'pedalcms_instruct_mode',
	'query_var' => 'inst_mode',
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

pedalcms_get_template_part( 'common/filters/taxonomy', $pedalcms_args );
