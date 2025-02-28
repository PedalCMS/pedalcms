<?php
/**
 * Displays a Person Category taxonomy dropdown filter.
 *
 * @package PedalCMS
 * @subpackage Templates
 * @version 1.0
 */


defined('ABSPATH') || exit;

$defaults = [
    'taxonomy'    => 'pdl_person_cat',
    'query_var'   => 'person_cat'
];

$args = pdl_parse_template_args($args, $defaults, $template);

pdl_get_template_part('filters/taxonomy', $args);
