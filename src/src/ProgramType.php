<?php

namespace InvisibleUs\Programs;

class ProgramType extends CustomTaxonomy {
    public const taxonomy = 'nvis_program_type';
    public $name = 'Program Type';
    public $plural_name = 'Program Types';

    public $object_types = [Program::post_type];

    public $args = [
        'query_var'             => 'prog_type',
        'rewrite'               => ['slug' => 'type'],
        'description'           => '',
        'sort'                  => true,
        'rewrite'               => false,
        'hierarchical'          => true,
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
