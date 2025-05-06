<?php

namespace PedalCMS\Core;

/**
 * Subject custom taxonomy.
 *
 * @package PedalCMS\Core\ContentModel
 * @since 0.1.0
 */
class Subject extends CustomTaxonomy {
    /**
     * @inheritdoc
     */
    public const TAXONOMY = 'pdl_subject';

    /**
     * @inheritdoc
     */
    public $object_types = [Course::POST_TYPE];

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    protected function setup_labels(): void {
        $this->args['labels'] = [
            'name'                       => _x( 'Subjects', 'taxonomy general name' , 'pedalcms'),
            'singular_name'              => _x( 'Subject', 'taxonomy singular name', 'pedalcms' ),
            'search_items'               => __( 'Search Subjects' , 'pedalcms'),
            'popular_items'              => __( 'Popular Subjects', 'pedalcms' ),
            'all_items'                  => __( 'All Subjects' , 'pedalcms'),
            'parent_item'                => __( 'Parent Subject' , 'pedalcms'),
            'parent_item_colon'          => __( 'Parent Subject:' , 'pedalcms'),
            'edit_item'                  => __( 'Edit Subject' , 'pedalcms'),
            'view_item'                  => __( 'View Subject' , 'pedalcms'),
            'update_item'                => __( 'Update Subject' , 'pedalcms'),
            'add_new_item'               => __( 'Add New Subject', 'pedalcms' ),
            'new_item_name'              => __( 'New Subject Name', 'pedalcms' ),
            'separate_items_with_commas' => __( 'Separate subjects with commas' , 'pedalcms'),
            'add_or_remove_items'        => __( 'Add or remove subjects', 'pedalcms' ),
            'choose_from_most_used'      => __( 'Choose from the most used subjects' , 'pedalcms'),
            'not_found'                  => __( 'No subjects found.' , 'pedalcms'),
            'no_terms'                   => __( 'No subjects' , 'pedalcms'),
            'filter_by_item'             => __( 'Filter by subject' , 'pedalcms'),
            'items_list_navigation'      => __( 'Subject list navigation' , 'pedalcms'),
            'items_list'                 => __( 'Subject list', 'pedalcms' ),
            'back_to_items'              => __( '&larr; Go to Subjects' , 'pedalcms'),
            'item_link'                  => _x( 'Subject Link', 'navigation link block title' , 'pedalcms'),
            'item_link_description'      => _x( 'A link to a subject.', 'navigation link block description', 'pedalcms' ),
        ];
    }
}
