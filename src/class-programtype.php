<?php

namespace PedalCMS\Core;

/**
 * Program Type custom taxonomy.
 *
 * @package PedalCMS\Core\ContentModel
 * @since 0.1.0
 */
class ProgramType extends CustomTaxonomy {
	/**
	 * @inheritdoc
	 */
	public const TAXONOMY = 'pedalcms_program_type';

	/**
	 * @inheritdoc
	 */
	public $object_types = [ Program::POST_TYPE ];

	/**
	 * @inheritdoc
	 */
	public array $args = [
		'query_var'          => 'prog_type',
		'rewrite'            => [ 'slug' => 'program-type' ],
		'description'        => '',
		'sort'               => true,
		'hierarchical'       => true,
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
			'name'                       => _x( 'Program Types', 'taxonomy general name', 'pedal-cms' ),
			'singular_name'              => _x( 'Program Type', 'taxonomy singular name', 'pedal-cms' ),
			'search_items'               => __( 'Search Program Types', 'pedal-cms' ),
			'popular_items'              => __( 'Popular Program Types', 'pedal-cms' ),
			'all_items'                  => __( 'All Program Types', 'pedal-cms' ),
			'parent_item'                => __( 'Parent Program Type', 'pedal-cms' ),
			'parent_item_colon'          => __( 'Parent Program Type:', 'pedal-cms' ),
			'edit_item'                  => __( 'Edit Program Type', 'pedal-cms' ),
			'view_item'                  => __( 'View Program Type', 'pedal-cms' ),
			'update_item'                => __( 'Update Program Type', 'pedal-cms' ),
			'add_new_item'               => __( 'Add New Program Type', 'pedal-cms' ),
			'new_item_name'              => __( 'New Program Type Name', 'pedal-cms' ),
			'separate_items_with_commas' => __( 'Separate program types with commas', 'pedal-cms' ),
			'add_or_remove_items'        => __( 'Add or remove program types', 'pedal-cms' ),
			'choose_from_most_used'      => __( 'Choose from the most used program types', 'pedal-cms' ),
			'not_found'                  => __( 'No program types found.', 'pedal-cms' ),
			'no_terms'                   => __( 'No program types', 'pedal-cms' ),
			'filter_by_item'             => __( 'Filter by program type', 'pedal-cms' ),
			'items_list_navigation'      => __( 'Program Type list navigation', 'pedal-cms' ),
			'items_list'                 => __( 'Program Type list', 'pedal-cms' ),
			'back_to_items'              => __( '&larr; Go to Program Types', 'pedal-cms' ),
			'item_link'                  => _x( 'Program Type Link', 'navigation link block title', 'pedal-cms' ),
			'item_link_description'      => _x( 'A link to a program type.', 'navigation link block description', 'pedal-cms' ),
		];
	}
}
