<?php
/**
 * A template for displaying the Course archive search and filter form.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 *
 */

defined('ABSPATH') || exit;

$data = [
    'post_type' => 'nvis_program',
    'filters'   => [
        'keyword',
        'program-type',
        'program-format',
        'college'
    ]
];

nvis_prog_get_template_part('common/filters', $data);
