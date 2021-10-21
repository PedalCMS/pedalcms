<?php

defined('ABSPATH') || exit;

$data = [
    'taxonomy'    => 'nvis_program_format',
    'query_var'   => 'prog_format',
    'label'       => 'Program Format',
    'short_label' => 'Format'
];

nvis_prog_get_template_part('filters/taxonomy', $data);
