<?php

namespace InvisibleUs\Programs;

/**
 * Semester custom taxonomy.
 * 
 * @version 0.1.0
 * @package nvis-programs
 * @since 0.1.0
 */
class Semester extends CustomTaxonomy {
    public const TAXONOMY = 'nvis_semester';
    public string $name = 'Term';
    public string $plural_name = 'Terms';

    public $object_types = [Course::POST_TYPE];

    public array $args = [
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
