<?php

$data = [
    'post_type' => 'nvis_person',
    'filters'   => [
        'keyword',
        'person-category',
        'college',
        'department'
    ]
];

nvis_prog_get_template_part('filters', $data);
