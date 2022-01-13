<?php
/**
 * Displays a Person Category taxonomy dropdown filter.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */


defined('ABSPATH') || exit;

$defaults = [
    'taxonomy'    => 'nvis_person_cat',
    'query_var'   => 'person_cat',
    'label'       => nvis_prog_get_label('person_category'),
];

$args = wp_parse_args($args, $defaults);

nvis_prog_get_template_part('filters/taxonomy', $args);
