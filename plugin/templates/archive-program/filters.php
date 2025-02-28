<?php
/**
 * A template for displaying the Program archive search and filter form.
 *
 * @package PedalCMS
 * @subpackage Templates
 * @version 1.0
 *
 */

defined('ABSPATH') || exit;

$defaults = [
    'post_type' => 'pdl_program',
    'break_filters_after' => 3,
    'filters'   => [
        'keyword',
        'program-type',
        'instruct-mode',
        'college',
        'department'
    ]
];

$args = pdl_parse_template_args($args, $defaults, $template);

pdl_get_template_part('common/filters', $args);
