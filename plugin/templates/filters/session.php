<?php
/**
 * Displays a Semester taxonomy dropdown filter.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$args = [
    'taxonomy'  => 'nvis_session',
    'query_var' => 'sess',
    'label'     => 'Term'
];

nvis_prog_get_template_part('filters/taxonomy', $args);
