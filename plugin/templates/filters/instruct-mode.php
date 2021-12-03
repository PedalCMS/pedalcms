<?php
/**
 * Displays an Instruction Mode taxonomy dropdown filter.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'taxonomy'    => 'nvis_instruct_mode',
    'query_var'   => 'inst_mode',
    'label'       => 'Instruction Mode',
    'short_label' => 'Mode'
];

$args = wp_parse_args($args, $defaults);

nvis_prog_get_template_part('filters/taxonomy', $args);
