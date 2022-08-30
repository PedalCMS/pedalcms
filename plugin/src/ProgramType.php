<?php

namespace InvisibleUs\Programs;

/**
 * Program Type custom taxonomy.
 *
 * @package NVISPrograms
 * @subpackage ContentModel
 * @since 0.1.0
 */
class ProgramType extends CustomTaxonomy {
    public const TAXONOMY = 'nvis_program_type';

    public $object_types = [Program::POST_TYPE];

    public array $args = [
        'query_var'             => 'prog_type',
        'rewrite'               => ['slug' => 'program-type'],
        'description'           => '',
        'sort'                  => true,
        'hierarchical'          => true,
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
            'name'                       => _x( 'Program Types', 'taxonomy general name' , 'nvis-program-pages'),
            'singular_name'              => _x( 'Program Type', 'taxonomy singular name', 'nvis-program-pages' ),
            'search_items'               => __( 'Search Program Types' , 'nvis-program-pages'),
            'popular_items'              => __( 'Popular Program Types', 'nvis-program-pages' ),
            'all_items'                  => __( 'All Program Types' , 'nvis-program-pages'),
            'parent_item'                => __( 'Parent Program Type' , 'nvis-program-pages'),
            'parent_item_colon'          => __( 'Parent Program Type:' , 'nvis-program-pages'),
            'edit_item'                  => __( 'Edit Program Type' , 'nvis-program-pages'),
            'view_item'                  => __( 'View Program Type' , 'nvis-program-pages'),
            'update_item'                => __( 'Update Program Type' , 'nvis-program-pages'),
            'add_new_item'               => __( 'Add New Program Type', 'nvis-program-pages' ),
            'new_item_name'              => __( 'New Program Type Name', 'nvis-program-pages' ),
            'separate_items_with_commas' => __( 'Separate program types with commas' , 'nvis-program-pages'),
            'add_or_remove_items'        => __( 'Add or remove program types', 'nvis-program-pages' ),
            'choose_from_most_used'      => __( 'Choose from the most used program types' , 'nvis-program-pages'),
            'not_found'                  => __( 'No program types found.' , 'nvis-program-pages'),
            'no_terms'                   => __( 'No program types' , 'nvis-program-pages'),
            'filter_by_item'             => __( 'Filter by program type' , 'nvis-program-pages'),
            'items_list_navigation'      => __( 'Program Type list navigation' , 'nvis-program-pages'),
            'items_list'                 => __( 'Program Type list', 'nvis-program-pages' ),
            'back_to_items'              => __( '&larr; Go to Program Types' , 'nvis-program-pages'),
            'item_link'                  => _x( 'Program Type Link', 'navigation link block title' , 'nvis-program-pages'),
            'item_link_description'      => _x( 'A link to a program type.', 'navigation link block description', 'nvis-program-pages' ),
        ];
    }

    protected function setup_field_group(): void {
        $field_group = [
            'key'         => 'group_6123fad662541',
            'title'       => __('Program Type Info', 'nvis-program-pages'),
            'description' => '',
            'location'    => [
                [
                    [
                        'param'    => 'taxonomy',
                        'operator' => '==',
                        'value'    => self::TAXONOMY,
                    ],
                ]
            ],
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'seamless',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'active'                => true,
            'fields'                => [
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
                [
                    'key'          => 'field_6258620b066a4',
                    'label'        => __('Application Deadlines', 'nvis-program-pages'),
                    'name'         => 'application_deadlines',
                    'type'         => 'repeater',
                    'instructions' => '',
                    'collapsed'    => 'field_62586243abee2',
                    'layout'       => 'block',
                    'button_label' => _x('Add Deadline', 'new deadline button label', 'nvis-program-pages'),
                    'sub_fields'   => [
                        [
                            'key'          => 'field_62586243abee2',
                            'label'        => __('Deadline Label', 'nvis-program-pages'),
                            'name'         => 'label',
                            'type'         => 'text',
                            'instructions' => '',
                            'required'     => 1,
                            'placeholder'  => _x('Fall, Spring, etc.', 'deadline label field placeholder', 'nvis-program-pages'),
                            'maxlength'    => '',
                        ],
                        [
                            'key'          => 'field_625862518454f',
                            'label'        => __('Deadline Info', 'nvis-program-pages'),
                            'name'         => 'info',
                            'type'         => 'text',
                            'instructions' => '',
                            'placeholder'  => _x('e.g. June 24th', 'deadline info field placeholder', 'nvis-program-pages'),
                            'maxlength'    => '',
                        ],
                    ],
                ],
            ],
        ];

        $this->field_groups[] = $field_group;
    }
}
