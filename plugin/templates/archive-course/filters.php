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

$args = [
    'post_type'           => 'nvis_course',
    'break_filters_after' => 3,
    'filters'             => [
        'keyword',
        'session',
        'subject',
        'college',
        'department'
    ]
];

nvis_prog_get_template_part('common/filters', $args);
