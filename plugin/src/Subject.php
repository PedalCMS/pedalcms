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

    protected function setup_labels(): void {
        $this->args['labels'] = [
            'name'                       => _x( 'Subjects', 'taxonomy general name' , 'nvis-program-pages'), 
            'singular_name'              => _x( 'Subject', 'taxonomy singular name', 'nvis-program-pages' ),
            'search_items'               => __( 'Search Subjects' , 'nvis-program-pages'), 
            'popular_items'              => __( 'Popular Subjects', 'nvis-program-pages' ),
            'all_items'                  => __( 'All Subjects' , 'nvis-program-pages'), 
            'parent_item'                => __( 'Parent Subject' , 'nvis-program-pages'), 
            'parent_item_colon'          => __( 'Parent Subject:' , 'nvis-program-pages'), 
            'edit_item'                  => __( 'Edit Subject' , 'nvis-program-pages'), 
            'view_item'                  => __( 'View Subject' , 'nvis-program-pages'), 
            'update_item'                => __( 'Update Subject' , 'nvis-program-pages'), 
            'add_new_item'               => __( 'Add New Subject', 'nvis-program-pages' ),
            'new_item_name'              => __( 'New Subject Name', 'nvis-program-pages' ),
            'separate_items_with_commas' => __( 'Separate subjects with commas' , 'nvis-program-pages'), 
            'add_or_remove_items'        => __( 'Add or remove subjects', 'nvis-program-pages' ),
            'choose_from_most_used'      => __( 'Choose from the most used subjects' , 'nvis-program-pages'), 
            'not_found'                  => __( 'No subjects found.' , 'nvis-program-pages'), 
            'no_terms'                   => __( 'No subjects' , 'nvis-program-pages'), 
            'filter_by_item'             => __( 'Filter by subject' , 'nvis-program-pages'), 
            'items_list_navigation'      => __( 'Subject list navigation' , 'nvis-program-pages'), 
            'items_list'                 => __( 'Subject list', 'nvis-program-pages' ),
            'back_to_items'              => __( '&larr; Go to Subjects' , 'nvis-program-pages'), 
            'item_link'                  => _x( 'Subject Link', 'navigation link block title' , 'nvis-program-pages'), 
            'item_link_description'      => _x( 'A link to a subject.', 'navigation link block description', 'nvis-program-pages' ),
        ];
    }
}
