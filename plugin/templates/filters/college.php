<?php
/**
 * Displays a College taxonomy dropdown filter.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'taxonomy'  => 'nvis_college',
    'query_var' => 'college'
];

$args = nvis_parse_template_args($args, $defaults, $template);

pdl_get_template_part('filters/taxonomy', $args);
