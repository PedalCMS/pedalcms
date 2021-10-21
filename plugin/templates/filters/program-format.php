<?php
/**
 * Displays a Program Format taxonomy dropdown filter.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$data = [
    'taxonomy'    => 'nvis_program_format',
    'query_var'   => 'prog_format',
    'label'       => 'Program Format',
    'short_label' => 'Format'
];

nvis_prog_get_template_part('filters/taxonomy', $data);
