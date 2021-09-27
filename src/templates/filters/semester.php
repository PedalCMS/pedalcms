<?php

$data = [
    'taxonomy'  => 'nvis_semester',
    'query_var' => 'sem_term',
    'label'     => 'Term'
];

nvis_prog_get_template_part('filters/taxonomy', $data);
