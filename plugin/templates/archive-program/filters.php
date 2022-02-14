<?php
/**
 * A template for displaying the Program archive search and filter form.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 *
 */

defined('ABSPATH') || exit;

$args = [
    'post_type' => 'nvis_program',
    'break_filters_after' => 3,
    'filters'   => [
        'keyword',
        'program-type',
        'instruct-mode',
        'college',
        'department'
    ]
];

nvis_prog_get_template_part('common/filters', $args);
