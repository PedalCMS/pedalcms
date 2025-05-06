<?php
/**
 * Displays a Program Type taxonomy dropdown filter.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'taxonomy'  => 'pdl_program_type',
    'query_var' => 'prog_type',
];

$args = pdl_parse_template_args($args, $defaults, $template);

pdl_get_template_part('filters/taxonomy', $args);
