<?php

$data = [
    'taxonomy'  => 'nvis_program_type',
    'query_var' => 'prog_type',
    'label'     => 'Program Type'
];

nvis_prog_get_template_part('filters/taxonomy', $data);
