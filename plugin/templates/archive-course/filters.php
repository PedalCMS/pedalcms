<?php

$data = [
    'post_type' => 'nvis_course',
    'filters'   => [
        'keyword',
        'subject',
        'semester'
    ]
];

nvis_prog_get_template_part('common/filters', $data);
