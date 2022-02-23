<?php
/**
 * Displays a College taxonomy dropdown filter.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'taxonomy'  => 'nvis_program_college',
    'query_var' => 'college',
    'label'     => nvis_prog_get_label('college')
];

$args = nvis_parse_template_args($args, $defaults, $template);

nvis_prog_get_template_part('filters/taxonomy', $args);
