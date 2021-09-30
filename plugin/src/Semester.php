<?php

namespace InvisibleUs\Programs;

class Semester extends CustomTaxonomy {
    public const taxonomy = 'nvis_semester';
    public $name = 'Term';
    public $plural_name = 'Terms';

    public $object_types = [Course::POST_TYPE];

    public $args = [
        'query_var'             => 'sem_term',
        'description'           => '',
        'sort'                  => true,
        'rewrite'               => false,
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => false,
        'show_tagcloud'         => false,
    ];

    public $field_groups = [];
}
