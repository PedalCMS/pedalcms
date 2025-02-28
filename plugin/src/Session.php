<?php

namespace PedalCMS\Core;

/**
 * Session custom taxonomy.
 *
 * @package NVISPrograms
 * @subpackage ContentModel
 * @since 0.1.0
 */
class Session extends CustomTaxonomy {
    public const TAXONOMY = 'nvis_session';
    public string $name = 'Term';
    public string $plural_name = 'Terms';

    public $object_types = [Course::POST_TYPE];

    public array $args = [
        'query_var'             => 'sess',
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
            'name'                       => _x( 'Sessions', 'taxonomy general name' , 'nvis-program-pages'), 
            'singular_name'              => _x( 'Session', 'taxonomy singular name', 'nvis-program-pages' ),
            'search_items'               => __( 'Search Sessions' , 'nvis-program-pages'), 
            'popular_items'              => __( 'Popular Sessions', 'nvis-program-pages' ),
            'all_items'                  => __( 'All Sessions' , 'nvis-program-pages'), 
            'parent_item'                => __( 'Parent Session' , 'nvis-program-pages'), 
            'parent_item_colon'          => __( 'Parent Session:' , 'nvis-program-pages'), 
            'edit_item'                  => __( 'Edit Session' , 'nvis-program-pages'), 
            'view_item'                  => __( 'View Session' , 'nvis-program-pages'), 
            'update_item'                => __( 'Update Session' , 'nvis-program-pages'), 
            'add_new_item'               => __( 'Add New Session', 'nvis-program-pages' ),
            'new_item_name'              => __( 'New Session Name', 'nvis-program-pages' ),
            'separate_items_with_commas' => __( 'Separate sessions with commas' , 'nvis-program-pages'), 
            'add_or_remove_items'        => __( 'Add or remove sessions', 'nvis-program-pages' ),
            'choose_from_most_used'      => __( 'Choose from the most used sessions' , 'nvis-program-pages'), 
            'not_found'                  => __( 'No sessions found.' , 'nvis-program-pages'), 
            'no_terms'                   => __( 'No sessions' , 'nvis-program-pages'), 
            'filter_by_item'             => __( 'Filter by session' , 'nvis-program-pages'), 
            'items_list_navigation'      => __( 'Session list navigation' , 'nvis-program-pages'), 
            'items_list'                 => __( 'Session list', 'nvis-program-pages' ),
            'back_to_items'              => __( '&larr; Go to Sessions' , 'nvis-program-pages'), 
            'item_link'                  => _x( 'Session Link', 'navigation link block title' , 'nvis-program-pages'), 
            'item_link_description'      => _x( 'A link to a session.', 'navigation link block description', 'nvis-program-pages' ),
        ];
    }
}
