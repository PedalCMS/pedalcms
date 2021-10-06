<?php

namespace InvisibleUs\Programs;

/**
 * Department custom taxonomy.
 * 
 * @package NVISPrograms
 * @subpackage ContentModel
 * @since 0.1.0
 */
class Department extends CustomTaxonomy {
    public const TAXONOMY = 'nvis_department';
    public string $name = 'Department';
    public string $plural_name = 'Departments';

    public $object_types = [Person::POST_TYPE];

    public array $args = [
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
