<?php

$data = [
    'taxonomy'    => 'nvis_department',
    'query_var'   => 'dept',
    'label'       => 'Department',
];

nvis_prog_get_template_part('filters/taxonomy', $data);
