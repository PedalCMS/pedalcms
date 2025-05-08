<?php

namespace PedalCMS\Core;

/**
 * Person Category custom taxonomy.
 *
 * @package PedalCMS\Core\ContentModel
 * @since 0.1.0
 */
class PersonCategory extends CustomTaxonomy {
    /**
     * @inheritdoc
     */
    public const TAXONOMY = 'pdl_person_cat';

    /**
     * @inheritdoc
     */
    public $object_types = [Person::POST_TYPE];

    /**
     * @inheritdoc
     */
    public array $args = [
        'query_var'             => 'person_cat',
        'description'           => '',
        'sort'                  => true,
        'rewrite'               => ['slug' => 'personnel-category'],
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'meta_box_cb'           => false,
        'show_in_quick_edit'    => false,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => false,
        'show_tagcloud'         => false,
    ];

    /**
     * @inheritdoc
     */
    protected function setup_labels(): void {
        $this->args['labels'] = [
            'name'                       => _x( 'Personnel Categories', 'taxonomy general name' , 'pedalcms'),
            'singular_name'              => _x( 'Personnel Category', 'taxonomy singular name', 'pedalcms' ),
            'search_items'               => __( 'Search Personnel Categories' , 'pedalcms'),
            'popular_items'              => __( 'Popular Personnel Categories', 'pedalcms' ),
            'all_items'                  => __( 'All Personnel Categories' , 'pedalcms'),
            'parent_item'                => __( 'Parent Personnel Category' , 'pedalcms'),
            'parent_item_colon'          => __( 'Parent Personnel Category:' , 'pedalcms'),
            'edit_item'                  => __( 'Edit Personnel Category' , 'pedalcms'),
            'view_item'                  => __( 'View Personnel Category' , 'pedalcms'),
            'update_item'                => __( 'Update Personnel Category' , 'pedalcms'),
            'add_new_item'               => __( 'Add New Personnel Category', 'pedalcms' ),
            'new_item_name'              => __( 'New Personnel Category Name', 'pedalcms' ),
            'separate_items_with_commas' => __( 'Separate personnel categories with commas' , 'pedalcms'),
            'add_or_remove_items'        => __( 'Add or remove personnel categories', 'pedalcms' ),
            'choose_from_most_used'      => __( 'Choose from the most used personnel categories' , 'pedalcms'),
            'not_found'                  => __( 'No personnel categories found.' , 'pedalcms'),
            'no_terms'                   => __( 'No personnel categories' , 'pedalcms'),
            'filter_by_item'             => __( 'Filter by personnel category' , 'pedalcms'),
            'items_list_navigation'      => __( 'Personnel Category list navigation' , 'pedalcms'),
            'items_list'                 => __( 'Personnel Category list', 'pedalcms' ),
            'back_to_items'              => __( '&larr; Go to Personnel Categories' , 'pedalcms'),
            'item_link'                  => _x( 'Personnel Category Link', 'navigation link block title' , 'pedalcms'),
            'item_link_description'      => _x( 'A link to a personnel category.', 'navigation link block description', 'pedalcms' ),
            'none_selected'              => _x( 'Any Category', 'dropdown list none selected', 'pedalcms'),
        ];
    }

    /**
     * @inheritdoc
     */
    protected function setup_field_group() {
        $field_group = [
            'key'    => 'group_630e259905811',
            'title'  => __('Personnel Category Info', 'pedalcms'),
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
                    'label'         => __('Featured Image', 'pedalcms'),
                    'name'          => 'featured_image',
                    'type'          => 'image',
                    'instructions'  => '',
                    'return_format' => 'url',
                    'preview_size'  => 'medium',
                    'library'       => 'all'
                ],
                [
                    'key'               => 'field_630e13fdc975c',
                    'label'             => __('Header Background Image', 'pedalcms'),
                    'name'              => 'header_background',
                    'type'              => 'image',
                    'instructions'      => __('The background image of the archive page header (Tuxedo Mode only).', 'pedalcms'),
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
