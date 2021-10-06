<?php

namespace InvisibleUs\Programs;

/**
 * Delivery Format custom taxonomy.
 * 
 * @package NVISPrograms
 * @subpackage ContentModel
 * @since 0.1.0
 */
class DeliveryFormat extends CustomTaxonomy {
    public const TAXONOMY = 'nvis_program_format';
    public string $name = 'Delivery Format';
    public string $plural_name = 'Delivery Formats';

    public $object_types = [Program::POST_TYPE];

    public array $args = [
        'query_var'             => 'prog_format',
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
