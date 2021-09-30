<?php

namespace InvisibleUs\Programs;

class Department extends CustomTaxonomy {
    public const TAXONOMY = 'nvis_department';
    public $name = 'Department';
    public $plural_name = 'Departments';

    public $object_types = [Person::POST_TYPE];

    public $args = [
        'query_var'             => 'dept',
        'description'           => '',
        'sort'                  => true,
        'rewrite'               => false,
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_quick_edit'    => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => false,
        'show_tagcloud'         => false,
    ];

    public $field_groups = [];
}
