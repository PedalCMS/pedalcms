<?php
/**
 * Displays an Instruction Mode taxonomy dropdown filter.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'taxonomy'    => 'pdl_instruct_mode',
    'query_var'   => 'inst_mode',
];

$args = pdl_parse_template_args($args, $defaults, $template);

pdl_get_template_part('filters/taxonomy', $args);
