<?php

namespace InvisibleUs\Programs;

/**
 * College custom taxonomy.
 *
 * @package NVISPrograms
 * @subpackage ContentModel
 * @since 0.1.0
 */
class College extends CustomTaxonomy {
    public const TAXONOMY = 'nvis_college';

    public $object_types = [Program::POST_TYPE, Person::POST_TYPE, Course::POST_TYPE];

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

    protected function setup_labels(): void {
        $this->args['labels'] = [
            'name'                       => _x('Colleges', 'taxonomy general name', 'nvis-program-pages'), 
            'singular_name'              => _x('College', 'taxonomy singular name', 'nvis-program-pages'),
            'search_items'               => __('Search Colleges', 'nvis-program-pages'), 
            'popular_items'              => __('Popular Colleges', 'nvis-program-pages'),
            'all_items'                  => __('All Colleges', 'nvis-program-pages'), 
            'parent_item'                => __('Parent College', 'nvis-program-pages'), 
            'parent_item_colon'          => __('Parent College:', 'nvis-program-pages'), 
            'edit_item'                  => __('Edit College', 'nvis-program-pages'), 
            'view_item'                  => __('View College', 'nvis-program-pages'), 
            'update_item'                => __('Update College', 'nvis-program-pages'), 
            'add_new_item'               => __('Add New College', 'nvis-program-pages'),
            'new_item_name'              => __('New College Name', 'nvis-program-pages'),
            'separate_items_with_commas' => __('Separate colleges with commas', 'nvis-program-pages'), 
            'add_or_remove_items'        => __('Add or remove colleges', 'nvis-program-pages'),
            'choose_from_most_used'      => __('Choose from the most used colleges', 'nvis-program-pages'), 
            'not_found'                  => __('No colleges found.', 'nvis-program-pages'), 
            'no_terms'                   => __('No colleges', 'nvis-program-pages'), 
            'filter_by_item'             => __('Filter by college', 'nvis-program-pages'), 
            'items_list_navigation'      => __('Colleges list navigation', 'nvis-program-pages'), 
            'items_list'                 => __('Colleges list', 'nvis-program-pages'),
            'back_to_items'              => __('&larr; Go to Colleges', 'nvis-program-pages'), 
            'item_link'                  => _x('College Link', 'navigation link block title', 'nvis-program-pages'), 
            'item_link_description'      => _x('A link to a college.', 'navigation link block description', 'nvis-program-pages'),
        ];
    }
}
