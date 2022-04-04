<?php

namespace InvisibleUs\Programs;

/**
 * Person Category custom taxonomy.
 * 
 * @package NVISPrograms
 * @subpackage ContentModel
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

    protected function setup_labels(): void {
        $this->args['labels'] = [
            'name'                       => _x( 'Personnel Categories', 'taxonomy general name' , 'nvis-program-pages'), 
            'singular_name'              => _x( 'Personnel Category', 'taxonomy singular name', 'nvis-program-pages' ),
            'search_items'               => __( 'Search Personnel Categories' , 'nvis-program-pages'), 
            'popular_items'              => __( 'Popular Personnel Categories', 'nvis-program-pages' ),
            'all_items'                  => __( 'All Personnel Categories' , 'nvis-program-pages'), 
            'parent_item'                => __( 'Parent Personnel Category' , 'nvis-program-pages'), 
            'parent_item_colon'          => __( 'Parent Personnel Category:' , 'nvis-program-pages'), 
            'edit_item'                  => __( 'Edit Personnel Category' , 'nvis-program-pages'), 
            'view_item'                  => __( 'View Personnel Category' , 'nvis-program-pages'), 
            'update_item'                => __( 'Update Personnel Category' , 'nvis-program-pages'), 
            'add_new_item'               => __( 'Add New Personnel Category', 'nvis-program-pages' ),
            'new_item_name'              => __( 'New Personnel Category Name', 'nvis-program-pages' ),
            'separate_items_with_commas' => __( 'Separate personnel categories with commas' , 'nvis-program-pages'), 
            'add_or_remove_items'        => __( 'Add or remove personnel categories', 'nvis-program-pages' ),
            'choose_from_most_used'      => __( 'Choose from the most used personnel categories' , 'nvis-program-pages'), 
            'not_found'                  => __( 'No personnel categories found.' , 'nvis-program-pages'), 
            'no_terms'                   => __( 'No personnel categories' , 'nvis-program-pages'), 
            'filter_by_item'             => __( 'Filter by personnel category' , 'nvis-program-pages'), 
            'items_list_navigation'      => __( 'Personnel Category list navigation' , 'nvis-program-pages'), 
            'items_list'                 => __( 'Personnel Category list', 'nvis-program-pages' ),
            'back_to_items'              => __( '&larr; Go to Personnel Categories' , 'nvis-program-pages'), 
            'item_link'                  => _x( 'Personnel Category Link', 'navigation link block title' , 'nvis-program-pages'), 
            'item_link_description'      => _x( 'A link to a personnel category.', 'navigation link block description', 'nvis-program-pages' ),
            'none_selected'              => _x( 'Any Category', 'dropdown list none selected', 'nvis-program-pages'),
        ];
    }
}
