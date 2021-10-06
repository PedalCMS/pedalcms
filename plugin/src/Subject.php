<?php

namespace InvisibleUs\Programs;

/**
 * Subject custom taxonomy.
 * 
 * @package NVISPrograms
 * @subpackage ContentModel
 * @since 0.1.0
 */
class Subject extends CustomTaxonomy {
    public const TAXONOMY = 'nvis_subject';
    public string $name = 'Subject';
    public string $plural_name = 'Subjects';

    public $object_types = [Course::POST_TYPE];

    public array $args = [
        'query_var'             => 'subj',
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
