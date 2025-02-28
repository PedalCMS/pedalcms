<?php

namespace PedalCMS\Core;

/**
 * Instruction Mode custom taxonomy.
 *
 * @package PedalCMS
 * @subpackage ContentModel
 * @since 0.1.0
 */
class InstructionMode extends CustomTaxonomy {
    public const TAXONOMY = 'pdl_instruct_mode';
    public string $name = 'Instruction Mode';
    public string $plural_name = 'Instruction Modes';

    public $object_types = [Program::POST_TYPE];

    public array $args = [
        'query_var'             => 'inst_mode',
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
            'name'                       => _x( 'Instruction Modes', 'taxonomy general name' , 'pedalcms'), 
            'singular_name'              => _x( 'Instruction Mode', 'taxonomy singular name', 'pedalcms' ),
            'search_items'               => __( 'Search Instruction Modes' , 'pedalcms'), 
            'popular_items'              => __( 'Popular Instruction Modes', 'pedalcms' ),
            'all_items'                  => __( 'All Instruction Modes' , 'pedalcms'), 
            'parent_item'                => __( 'Parent Instruction Mode' , 'pedalcms'), 
            'parent_item_colon'          => __( 'Parent Instruction Mode:' , 'pedalcms'), 
            'edit_item'                  => __( 'Edit Instruction Mode' , 'pedalcms'), 
            'view_item'                  => __( 'View Instruction Mode' , 'pedalcms'), 
            'update_item'                => __( 'Update Instruction Mode' , 'pedalcms'), 
            'add_new_item'               => __( 'Add New Instruction Mode', 'pedalcms' ),
            'new_item_name'              => __( 'New Instruction Mode Name', 'pedalcms' ),
            'separate_items_with_commas' => __( 'Separate instruction modes with commas' , 'pedalcms'), 
            'add_or_remove_items'        => __( 'Add or remove instruction modes', 'pedalcms' ),
            'choose_from_most_used'      => __( 'Choose from the most used instruction modes' , 'pedalcms'), 
            'not_found'                  => __( 'No instruction modes found.' , 'pedalcms'), 
            'no_terms'                   => __( 'No instruction modes' , 'pedalcms'), 
            'filter_by_item'             => __( 'Filter by instruction mode' , 'pedalcms'), 
            'items_list_navigation'      => __( 'Instruction Mode list navigation' , 'pedalcms'), 
            'items_list'                 => __( 'Instruction Mode list', 'pedalcms' ),
            'back_to_items'              => __( '&larr; Go to Instruction Modes' , 'pedalcms'), 
            'item_link'                  => _x( 'Instruction Mode Link', 'navigation link block title' , 'pedalcms'), 
            'item_link_description'      => _x( 'A link to a instruction mode.', 'navigation link block description', 'pedalcms' ),
            'none_selected'              => _x( 'Any Mode', 'dropdown list none selected', 'pedalcms'),
        ];
    }
}
