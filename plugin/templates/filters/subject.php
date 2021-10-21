<?php
/**
 * Displays a Subject taxonomy dropdown filter.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$args = [
    'taxonomy'  => 'nvis_subject',
    'query_var' => 'subj',
    'label'     => 'Subject'
];

nvis_prog_get_template_part('filters/taxonomy', $args);
