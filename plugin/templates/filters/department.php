<?php
/**
 * Displays a Department taxonomy dropdown filter.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$data = [
    'taxonomy'    => 'nvis_department',
    'query_var'   => 'dept',
    'label'       => 'Department',
];

nvis_prog_get_template_part('filters/taxonomy', $data);
