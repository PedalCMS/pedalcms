<?php
/**
 * Displays a Subject taxonomy dropdown filter.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'taxonomy'  => 'pdl_subject',
    'query_var' => 'subj',
];

$args = pdl_parse_template_args($args, $defaults, $template);

pdl_get_template_part('filters/taxonomy', $args);
