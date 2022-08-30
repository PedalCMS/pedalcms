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

    protected function setup_field_group() {
        $field_group = [
            'key'    => 'group_630e244b8c660',
            'title'  => __('Department Info', 'nvis-career-profiles'),
            'menu_order'            => 0,
            'position'              => 'acf_after_title',
            'style'                 => 'seamless',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'active'                => true,
            'description'           => '',
            'location'              => [
                [
                    [
                        'param'    => 'taxonomy',
                        'operator' => '==',
                        'value'    => static::TAXONOMY,
                    ],
                ],
            ],
            'fields' => [
                [
                    'key'           => 'field_6304c88d7d4aa',
                    'label'         => __('Featured Image', 'nvis-career-profiles'),
                    'name'          => 'featured_image',
                    'type'          => 'image',
                    'instructions'  => '',
                    'return_format' => 'url',
                    'preview_size'  => 'medium',
                    'library'       => 'all'
                ],
                [
                    'key'               => 'field_630e13fdc975c',
                    'label'             => __('Header Background Image', 'nvis-career-profiles'),
                    'name'              => 'header_background',
                    'type'              => 'image',
                    'instructions'      => __('The background image of the archive page header (Tuxedo Mode only).', 'nvis-career-profiles'),
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => 'present-mode-full',
                        'id'    => '',
                    ],
                    'return_format' => 'id',
                    'preview_size'  => 'medium',
                    'library'       => 'all',
                    'min_width'     => '',
                    'min_height'    => '',
                    'min_size'      => '',
                    'max_width'     => '',
                    'max_height'    => '',
                    'max_size'      => '',
                    'mime_types'    => '',
                ],
            ],
        ];

        $this->field_groups[] = $field_group;
    }
}
