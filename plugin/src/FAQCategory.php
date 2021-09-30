<?php

namespace InvisibleUs\Programs;

class FAQCategory extends CustomTaxonomy {
    public const TAXONOMY = 'nvis_faq_cat';
    public string $name = 'FAQ Category';
    public string $plural_name = 'FAQ Categories';

    public $object_types = [FAQ::POST_TYPE];

    public array $args = [
        'query_var'             => 'faq_cat',
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
