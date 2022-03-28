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

    public $object_types = [Program::POST_TYPE, Person::POST_TYPE, Course::POST_TYPE];

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

    protected function setup_labels(): void {
        $this->args['labels'] = [
            'name'                       => _x( 'Departments', 'taxonomy general name' , 'nvis-program-pages'), 
            'singular_name'              => _x( 'Department', 'taxonomy singular name', 'nvis-program-pages' ),
            'search_items'               => __( 'Search Departments' , 'nvis-program-pages'), 
            'popular_items'              => __( 'Popular Departments', 'nvis-program-pages' ),
            'all_items'                  => __( 'All Departments' , 'nvis-program-pages'), 
            'parent_item'                => __( 'Parent Department' , 'nvis-program-pages'), 
            'parent_item_colon'          => __( 'Parent Department:' , 'nvis-program-pages'), 
            'edit_item'                  => __( 'Edit Department' , 'nvis-program-pages'), 
            'view_item'                  => __( 'View Department' , 'nvis-program-pages'), 
            'update_item'                => __( 'Update Department' , 'nvis-program-pages'), 
            'add_new_item'               => __( 'Add New Department', 'nvis-program-pages' ),
            'new_item_name'              => __( 'New Department Name', 'nvis-program-pages' ),
            'separate_items_with_commas' => __( 'Separate departments with commas' , 'nvis-program-pages'), 
            'add_or_remove_items'        => __( 'Add or remove departments', 'nvis-program-pages' ),
            'choose_from_most_used'      => __( 'Choose from the most used departments' , 'nvis-program-pages'), 
            'not_found'                  => __( 'No departments found.' , 'nvis-program-pages'), 
            'no_terms'                   => __( 'No departments' , 'nvis-program-pages'), 
            'filter_by_item'             => __( 'Filter by category' , 'nvis-program-pages'), 
            'items_list_navigation'      => __( 'Departments list navigation' , 'nvis-program-pages'), 
            'items_list'                 => __( 'Departments list', 'nvis-program-pages' ),
            'back_to_items'              => __( '&larr; Go to Departments' , 'nvis-program-pages'), 
            'item_link'                  => _x( 'Department Link', 'navigation link block title' , 'nvis-program-pages'), 
            'item_link_description'      => _x( 'A link to a department.', 'navigation link block description', 'nvis-program-pages' ),
        ];
    }
}
