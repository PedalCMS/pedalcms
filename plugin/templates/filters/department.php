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

$args = nvis_parse_template_args($args, $defaults, $template);

nvis_prog_get_template_part('filters/taxonomy', $args);
