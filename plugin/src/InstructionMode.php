<?php

namespace InvisibleUs\Programs;

/**
 * Instruction Mode custom taxonomy.
 *
 * @package NVISPrograms
 * @subpackage ContentModel
 * @since 0.1.0
 */
class InstructionMode extends CustomTaxonomy {
    public const TAXONOMY = 'nvis_instruct_mode';
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
            'name'                       => _x( 'Instruction Modes', 'taxonomy general name' , 'nvis-program-pages'), 
            'singular_name'              => _x( 'Instruction Mode', 'taxonomy singular name', 'nvis-program-pages' ),
            'search_items'               => __( 'Search Instruction Modes' , 'nvis-program-pages'), 
            'popular_items'              => __( 'Popular Instruction Modes', 'nvis-program-pages' ),
            'all_items'                  => __( 'All Instruction Modes' , 'nvis-program-pages'), 
            'parent_item'                => __( 'Parent Instruction Mode' , 'nvis-program-pages'), 
            'parent_item_colon'          => __( 'Parent Instruction Mode:' , 'nvis-program-pages'), 
            'edit_item'                  => __( 'Edit Instruction Mode' , 'nvis-program-pages'), 
            'view_item'                  => __( 'View Instruction Mode' , 'nvis-program-pages'), 
            'update_item'                => __( 'Update Instruction Mode' , 'nvis-program-pages'), 
            'add_new_item'               => __( 'Add New Instruction Mode', 'nvis-program-pages' ),
            'new_item_name'              => __( 'New Instruction Mode Name', 'nvis-program-pages' ),
            'separate_items_with_commas' => __( 'Separate instruction modes with commas' , 'nvis-program-pages'), 
            'add_or_remove_items'        => __( 'Add or remove instruction modes', 'nvis-program-pages' ),
            'choose_from_most_used'      => __( 'Choose from the most used instruction modes' , 'nvis-program-pages'), 
            'not_found'                  => __( 'No instruction modes found.' , 'nvis-program-pages'), 
            'no_terms'                   => __( 'No instruction modes' , 'nvis-program-pages'), 
            'filter_by_item'             => __( 'Filter by instruction mode' , 'nvis-program-pages'), 
            'items_list_navigation'      => __( 'Instruction Mode list navigation' , 'nvis-program-pages'), 
            'items_list'                 => __( 'Instruction Mode list', 'nvis-program-pages' ),
            'back_to_items'              => __( '&larr; Go to Instruction Modes' , 'nvis-program-pages'), 
            'item_link'                  => _x( 'Instruction Mode Link', 'navigation link block title' , 'nvis-program-pages'), 
            'item_link_description'      => _x( 'A link to a instruction mode.', 'navigation link block description', 'nvis-program-pages' ),
            'none_selected'              => _x( 'Any Mode', 'dropdown list none selected', 'nvis-program-pages'),
        ];
    }
}
