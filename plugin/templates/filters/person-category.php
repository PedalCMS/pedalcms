<?php
/**
 * Displays a Person Category taxonomy dropdown filter.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */


defined('ABSPATH') || exit;

$data = [
    'taxonomy'    => 'nvis_person_cat',
    'query_var'   => 'person_cat',
    'label'       => 'Category',
];

nvis_prog_get_template_part('filters/taxonomy', $data);
