<?php

namespace InvisibleUs\Programs;

class DeliveryFormat extends CustomTaxonomy {
    public const taxonomy = 'nvis_program_format';
    public $name = 'Delivery Format';
    public $plural_name = 'Delivery Formats';

    public $object_types = [Program::POST_TYPE];

    public $args = [
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
