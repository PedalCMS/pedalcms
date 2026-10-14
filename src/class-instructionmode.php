<?php

namespace PedalCMS\Core;

/**
 * Instruction Mode custom taxonomy.
 *
 * @package PedalCMS\Core\ContentModel
 * @since 0.1.0
 */
class InstructionMode extends CustomTaxonomy {
	/**
	 * @inheritdoc
	 */
	public const TAXONOMY = 'pdl_instruct_mode';

	/**
	 * @inheritdoc
	 */
	public string $name = 'Instruction Mode';

	/**
	 * @inheritdoc
	 */
	public string $plural_name = 'Instruction Modes';

	/**
	 * @inheritdoc
	 */
	public $object_types = [ Program::POST_TYPE ];

	/**
	 * @inheritdoc
	 */
	public array $args = [
		'query_var'          => 'inst_mode',
		'rewrite'            => false,
		'description'        => '',
		'sort'               => true,
		'hierarchical'       => false,
		'public'             => true,
		'show_ui'            => true,
		'show_in_quick_edit' => false,
		'meta_box_cb'        => false,
		'show_admin_column'  => true,
		'show_in_nav_menus'  => false,
		'show_tagcloud'      => false,
	];

	/**
	 * @inheritdoc
	 */
	protected function setup_labels(): void {
		$this->args['labels'] = [
			'name'                       => _x( 'Instruction Modes', 'taxonomy general name', 'pedal-cms' ),
			'singular_name'              => _x( 'Instruction Mode', 'taxonomy singular name', 'pedal-cms' ),
			'search_items'               => __( 'Search Instruction Modes', 'pedal-cms' ),
			'popular_items'              => __( 'Popular Instruction Modes', 'pedal-cms' ),
			'all_items'                  => __( 'All Instruction Modes', 'pedal-cms' ),
			'parent_item'                => __( 'Parent Instruction Mode', 'pedal-cms' ),
			'parent_item_colon'          => __( 'Parent Instruction Mode:', 'pedal-cms' ),
			'edit_item'                  => __( 'Edit Instruction Mode', 'pedal-cms' ),
			'view_item'                  => __( 'View Instruction Mode', 'pedal-cms' ),
			'update_item'                => __( 'Update Instruction Mode', 'pedal-cms' ),
			'add_new_item'               => __( 'Add New Instruction Mode', 'pedal-cms' ),
			'new_item_name'              => __( 'New Instruction Mode Name', 'pedal-cms' ),
			'separate_items_with_commas' => __( 'Separate instruction modes with commas', 'pedal-cms' ),
			'add_or_remove_items'        => __( 'Add or remove instruction modes', 'pedal-cms' ),
			'choose_from_most_used'      => __( 'Choose from the most used instruction modes', 'pedal-cms' ),
			'not_found'                  => __( 'No instruction modes found.', 'pedal-cms' ),
			'no_terms'                   => __( 'No instruction modes', 'pedal-cms' ),
			'filter_by_item'             => __( 'Filter by instruction mode', 'pedal-cms' ),
			'items_list_navigation'      => __( 'Instruction Mode list navigation', 'pedal-cms' ),
			'items_list'                 => __( 'Instruction Mode list', 'pedal-cms' ),
			'back_to_items'              => __( '&larr; Go to Instruction Modes', 'pedal-cms' ),
			'item_link'                  => _x( 'Instruction Mode Link', 'navigation link block title', 'pedal-cms' ),
			'item_link_description'      => _x( 'A link to a instruction mode.', 'navigation link block description', 'pedal-cms' ),
			'none_selected'              => _x( 'Any Mode', 'dropdown list none selected', 'pedal-cms' ),
		];
	}
}
