<?php

$data = [
    'taxonomy'  => 'nvis_program_college',
    'query_var' => 'college',
    'label'     => 'College'
];

nvis_prog_get_template_part('filters/taxonomy', $data);
