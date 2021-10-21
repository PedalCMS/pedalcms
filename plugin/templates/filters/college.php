<?php
/**
 * Displays a College taxonomy dropdown filter.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$args = [
    'taxonomy'  => 'nvis_program_college',
    'query_var' => 'college',
    'label'     => 'College'
];

nvis_prog_get_template_part('filters/taxonomy', $args);
