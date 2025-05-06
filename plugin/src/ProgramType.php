<?php

namespace PedalCMS\Core;

/**
 * Program Type custom taxonomy.
 *
 * @package PedalCMS
 * @subpackage ContentModel
 * @since 0.1.0
 */
class ProgramType extends CustomTaxonomy {
    /**
     * @inheritdoc
     */
    public const TAXONOMY = 'pdl_program_type';

    /**
     * @inheritdoc
     */
    public $object_types = [Program::POST_TYPE];

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    protected function setup_labels(): void {
        $this->args['labels'] = [
            'name'                       => _x( 'Program Types', 'taxonomy general name' , 'pedalcms'),
            'singular_name'              => _x( 'Program Type', 'taxonomy singular name', 'pedalcms' ),
            'search_items'               => __( 'Search Program Types' , 'pedalcms'),
            'popular_items'              => __( 'Popular Program Types', 'pedalcms' ),
            'all_items'                  => __( 'All Program Types' , 'pedalcms'),
            'parent_item'                => __( 'Parent Program Type' , 'pedalcms'),
            'parent_item_colon'          => __( 'Parent Program Type:' , 'pedalcms'),
            'edit_item'                  => __( 'Edit Program Type' , 'pedalcms'),
            'view_item'                  => __( 'View Program Type' , 'pedalcms'),
            'update_item'                => __( 'Update Program Type' , 'pedalcms'),
            'add_new_item'               => __( 'Add New Program Type', 'pedalcms' ),
            'new_item_name'              => __( 'New Program Type Name', 'pedalcms' ),
            'separate_items_with_commas' => __( 'Separate program types with commas' , 'pedalcms'),
            'add_or_remove_items'        => __( 'Add or remove program types', 'pedalcms' ),
            'choose_from_most_used'      => __( 'Choose from the most used program types' , 'pedalcms'),
            'not_found'                  => __( 'No program types found.' , 'pedalcms'),
            'no_terms'                   => __( 'No program types' , 'pedalcms'),
            'filter_by_item'             => __( 'Filter by program type' , 'pedalcms'),
            'items_list_navigation'      => __( 'Program Type list navigation' , 'pedalcms'),
            'items_list'                 => __( 'Program Type list', 'pedalcms' ),
            'back_to_items'              => __( '&larr; Go to Program Types' , 'pedalcms'),
            'item_link'                  => _x( 'Program Type Link', 'navigation link block title' , 'pedalcms'),
            'item_link_description'      => _x( 'A link to a program type.', 'navigation link block description', 'pedalcms' ),
        ];
    }

    /**
     * @inheritdoc
     */
    protected function setup_field_group(): void {
        $field_group = [
            'key'         => 'group_6123fad662541',
            'title'       => __('Program Type Info', 'pedalcms'),
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
                    'label'        => __('Application Deadlines', 'pedalcms'),
                    'name'         => 'application_deadlines',
                    'type'         => 'repeater',
                    'instructions' => '',
                    'collapsed'    => 'field_62586243abee2',
                    'layout'       => 'block',
                    'button_label' => _x('Add Deadline', 'new deadline button label', 'pedalcms'),
                    'sub_fields'   => [
                        [
                            'key'          => 'field_62586243abee2',
                            'label'        => __('Deadline Label', 'pedalcms'),
                            'name'         => 'label',
                            'type'         => 'text',
                            'instructions' => '',
                            'required'     => 1,
                            'placeholder'  => _x('Fall, Spring, etc.', 'deadline label field placeholder', 'pedalcms'),
                            'maxlength'    => '',
                        ],
                        [
                            'key'          => 'field_625862518454f',
                            'label'        => __('Deadline Info', 'pedalcms'),
                            'name'         => 'info',
                            'type'         => 'text',
                            'instructions' => '',
                            'placeholder'  => _x('e.g. June 24th', 'deadline info field placeholder', 'pedalcms'),
                            'maxlength'    => '',
                        ],
                    ],
                ],
            ],
        ];

        $this->field_groups[] = $field_group;
    }
}
