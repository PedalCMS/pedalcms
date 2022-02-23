<?php
/**
 * Displays a Subject taxonomy dropdown filter.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'taxonomy'  => 'nvis_subject',
    'query_var' => 'subj',
    'label'     => nvis_prog_get_label('subject')
];

$args = nvis_parse_template_args($args, $defaults, $template);

nvis_prog_get_template_part('filters/taxonomy', $args);
