<?php
/**
 * Displays a Department taxonomy dropdown filter.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'taxonomy'  => 'nvis_department',
    'query_var' => 'dept',
    'label'     => nvis_prog_get_label('department'),
];

$args = wp_parse_args($args, $defaults);

nvis_prog_get_template_part('filters/taxonomy', $args);
