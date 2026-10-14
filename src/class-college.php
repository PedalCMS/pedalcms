<?php

namespace PedalCMS\Core;

/**
 * College custom taxonomy.
 *
 * @package PedalCMS\Core\ContentModel
 * @since 0.1.0
 */
class College extends CustomTaxonomy {
	/**
	 * @inheritdoc
	 */
	public const TAXONOMY = 'pdl_college';

	/**
	 * @inheritdoc
	 */
	public $object_types = [ Program::POST_TYPE, Person::POST_TYPE, Course::POST_TYPE ];

	/**
	 * @inheritdoc
	 */
	public array $args = [
		'query_var'          => 'college',
		'rewrite'            => [ 'slug' => 'college' ],
		'description'        => '',
		'sort'               => true,
		'hierarchical'       => false,
		'public'             => true,
		'show_ui'            => true,
		'show_in_quick_edit' => true,
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
			'name'                       => _x( 'Colleges', 'taxonomy general name', 'pedal-cms' ),
			'singular_name'              => _x( 'College', 'taxonomy singular name', 'pedal-cms' ),
			'search_items'               => __( 'Search Colleges', 'pedal-cms' ),
			'popular_items'              => __( 'Popular Colleges', 'pedal-cms' ),
			'all_items'                  => __( 'All Colleges', 'pedal-cms' ),
			'parent_item'                => __( 'Parent College', 'pedal-cms' ),
			'parent_item_colon'          => __( 'Parent College:', 'pedal-cms' ),
			'edit_item'                  => __( 'Edit College', 'pedal-cms' ),
			'view_item'                  => __( 'View College', 'pedal-cms' ),
			'update_item'                => __( 'Update College', 'pedal-cms' ),
			'add_new_item'               => __( 'Add New College', 'pedal-cms' ),
			'new_item_name'              => __( 'New College Name', 'pedal-cms' ),
			'separate_items_with_commas' => __( 'Separate colleges with commas', 'pedal-cms' ),
			'add_or_remove_items'        => __( 'Add or remove colleges', 'pedal-cms' ),
			'choose_from_most_used'      => __( 'Choose from the most used colleges', 'pedal-cms' ),
			'not_found'                  => __( 'No colleges found.', 'pedal-cms' ),
			'no_terms'                   => __( 'No colleges', 'pedal-cms' ),
			'filter_by_item'             => __( 'Filter by college', 'pedal-cms' ),
			'items_list_navigation'      => __( 'Colleges list navigation', 'pedal-cms' ),
			'items_list'                 => __( 'Colleges list', 'pedal-cms' ),
			'back_to_items'              => __( '&larr; Go to Colleges', 'pedal-cms' ),
			'item_link'                  => _x( 'College Link', 'navigation link block title', 'pedal-cms' ),
			'item_link_description'      => _x( 'A link to a college.', 'navigation link block description', 'pedal-cms' ),
		];
	}
}
