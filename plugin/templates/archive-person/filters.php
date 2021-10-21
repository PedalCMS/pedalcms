<?php
/**
 * A template for displaying the Person archive search and filter form.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 *
 */

defined('ABSPATH') || exit;

$args = [
    'post_type' => 'nvis_person',
    'filters'   => [
        'keyword',
        'person-category',
        'college',
        'department'
    ]
];

nvis_prog_get_template_part('common/filters', $args);
