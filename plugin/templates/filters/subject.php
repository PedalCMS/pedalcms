<?php

defined('ABSPATH') || exit;

$data = [
    'taxonomy'  => 'nvis_subject',
    'query_var' => 'subj',
    'label'     => 'Subject'
];

nvis_prog_get_template_part('filters/taxonomy', $data);
