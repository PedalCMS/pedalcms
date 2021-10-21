<?php
/**
 * Displays a Program Type taxonomy dropdown filter.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$args = [
    'taxonomy'  => 'nvis_program_type',
    'query_var' => 'prog_type',
    'label'     => 'Program Type'
];

nvis_prog_get_template_part('filters/taxonomy', $args);
