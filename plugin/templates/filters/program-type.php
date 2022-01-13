<?php
/**
 * Displays a Program Type taxonomy dropdown filter.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'taxonomy'  => 'nvis_program_type',
    'query_var' => 'prog_type',
    'label'     => nvis_prog_get_label('program_type')
];

$args = wp_parse_args($args, $defaults);

nvis_prog_get_template_part('filters/taxonomy', $args);
