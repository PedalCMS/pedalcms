<?php
/**
 * Displays an Instruction Mode taxonomy dropdown filter.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$args = [
    'taxonomy'    => 'nvis_instruct_mode',
    'query_var'   => 'inst_mode',
    'label'       => 'Instruction Mode',
    'short_label' => 'Mode'
];

nvis_prog_get_template_part('filters/taxonomy', $args);
