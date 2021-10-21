<?php

defined('ABSPATH') || exit;

$data = [
    'post_type' => 'nvis_program',
    'filters'   => [
        'keyword',
        'program-type',
        'program-format',
        'college'
    ]
];

nvis_prog_get_template_part('common/filters', $data);
