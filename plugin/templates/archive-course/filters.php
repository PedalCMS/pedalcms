<?php
/**
 * A template for displaying the Course archive search and filter form.
 *
 * @package PedalCMS
 * @subpackage Templates
 * @version 1.0
 *
 */

defined('ABSPATH') || exit;

$args = [
    'post_type'           => 'pdl_course',
    'break_filters_after' => 3,
    'filters'             => [
        'keyword',
        'session',
        'subject',
        'instruct-mode',
        'college',
        'department'
    ]
];

pdl_get_template_part('common/filters', $args);
