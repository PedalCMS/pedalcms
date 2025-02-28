<?php

namespace PedalCMS\Core;

/**
 * FAQ Category custom taxonomy.
 * 
 * @package NVISPrograms
 * @subpackage ContentModel
 * @since 0.1.0
 */
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

    protected function setup_labels(): void {
        $this->args['labels'] = [
            'name'                       => _x( 'FAQ Categories', 'taxonomy general name' , 'nvis-program-pages'), 
            'singular_name'              => _x( 'FAQ Category', 'taxonomy singular name', 'nvis-program-pages' ),
            'search_items'               => __( 'Search FAQ Categories' , 'nvis-program-pages'), 
            'popular_items'              => __( 'Popular FAQ Categories', 'nvis-program-pages' ),
            'all_items'                  => __( 'All FAQ Categories' , 'nvis-program-pages'), 
            'parent_item'                => __( 'Parent FAQ Category' , 'nvis-program-pages'), 
            'parent_item_colon'          => __( 'Parent FAQ Category:' , 'nvis-program-pages'), 
            'edit_item'                  => __( 'Edit FAQ Category' , 'nvis-program-pages'), 
            'view_item'                  => __( 'View FAQ Category' , 'nvis-program-pages'), 
            'update_item'                => __( 'Update FAQ Category' , 'nvis-program-pages'), 
            'add_new_item'               => __( 'Add New FAQ Category', 'nvis-program-pages' ),
            'new_item_name'              => __( 'New FAQ Category Name', 'nvis-program-pages' ),
            'separate_items_with_commas' => __( 'Separate FAQ categories with commas' , 'nvis-program-pages'), 
            'add_or_remove_items'        => __( 'Add or remove FAQ categories', 'nvis-program-pages' ),
            'choose_from_most_used'      => __( 'Choose from the most used FAQ categories' , 'nvis-program-pages'), 
            'not_found'                  => __( 'No FAQ categories found.' , 'nvis-program-pages'), 
            'no_terms'                   => __( 'No FAQ categories' , 'nvis-program-pages'), 
            'filter_by_item'             => __( 'Filter by category' , 'nvis-program-pages'), 
            'items_list_navigation'      => __( 'FAQ Categories list navigation' , 'nvis-program-pages'), 
            'items_list'                 => __( 'FAQ Categories list', 'nvis-program-pages' ),
            'back_to_items'              => __( '&larr; Go to FAQ Categories' , 'nvis-program-pages'), 
            'item_link'                  => _x( 'FAQ Category Link', 'navigation link block title' , 'nvis-program-pages'), 
            'item_link_description'      => _x( 'A link to a FAQ category.', 'navigation link block description', 'nvis-program-pages' ),
        ];
    }
}
