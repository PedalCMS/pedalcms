<?php

$data = [
    'taxonomy'    => 'nvis_person_cat',
    'query_var'   => 'person_cat',
    'label'       => 'Category',
];

nvis_prog_get_template_part('filters/taxonomy', $data);
