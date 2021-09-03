<?php

namespace InvisibleUs\Programs;

class College extends CustomTaxonomy {
    public const taxonomy = 'nvis_program_college';
    public $name = 'College';
    public $plural_name = 'Colleges';

    public $object_types = [Program::post_type];

    public $args = [
        'query_var'             => 'prog_college',
        'rewrite'               => false,
        'description'           => '',
        'sort'                  => true,
        'rewrite'               => false,
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_quick_edit'    => false,
        'meta_box_cb'           => false,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => false,
        'show_tagcloud'         => false,
    ];

    public $field_groups = [];
}
