<?php

namespace InvisibleUs\Programs;

/**
 * Person Category custom taxonomy.
 * 
 * @version 0.1.0
 * @package NVISPrograms
 * @since 0.1.0
 */
class PersonCategory extends CustomTaxonomy {
    public const TAXONOMY = 'nvis_person_cat';
    public string $name = 'Person Category';
    public string $plural_name = 'Person Categories';

    public $object_types = [Person::POST_TYPE];

    public array $args = [
        'query_var'             => 'person_cat',
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
