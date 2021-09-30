<?php

namespace InvisibleUs\Programs;

/**
 * College custom taxonomy.
 * 
 * @version 0.1.0
 * @package nvis-programs
 * @since 0.1.0
 */
class College extends CustomTaxonomy {
    public const TAXONOMY = 'nvis_program_college';
    public string $name = 'College';
    public string $plural_name = 'Colleges';

    public $object_types = [Program::POST_TYPE, Person::POST_TYPE];

    public array $args = [
        'query_var'             => 'college',
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
