<?php

namespace InvisibleUs\Programs;

class PersonCategory extends CustomTaxonomy {
    public const taxonomy = 'nvis_person_cat';
    public $name = 'Person Category';
    public $plural_name = 'Person Categories';

    public $object_types = [Person::post_type];

    public $args = [
        'query_var'             => 'person_cat',
        'rewrite'               => false,
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
