<?php
/**
 * Displays a Program Type taxonomy dropdown filter.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'taxonomy'  => 'pedalcms_program_type',
	'query_var' => 'prog_type',
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

pedalcms_get_template_part( 'common/filters/taxonomy', $pedalcms_args );
