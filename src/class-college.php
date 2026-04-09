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
			'name'                       => _x( 'Colleges', 'taxonomy general name', 'pedalcms' ),
			'singular_name'              => _x( 'College', 'taxonomy singular name', 'pedalcms' ),
			'search_items'               => __( 'Search Colleges', 'pedalcms' ),
			'popular_items'              => __( 'Popular Colleges', 'pedalcms' ),
			'all_items'                  => __( 'All Colleges', 'pedalcms' ),
			'parent_item'                => __( 'Parent College', 'pedalcms' ),
			'parent_item_colon'          => __( 'Parent College:', 'pedalcms' ),
			'edit_item'                  => __( 'Edit College', 'pedalcms' ),
			'view_item'                  => __( 'View College', 'pedalcms' ),
			'update_item'                => __( 'Update College', 'pedalcms' ),
			'add_new_item'               => __( 'Add New College', 'pedalcms' ),
			'new_item_name'              => __( 'New College Name', 'pedalcms' ),
			'separate_items_with_commas' => __( 'Separate colleges with commas', 'pedalcms' ),
			'add_or_remove_items'        => __( 'Add or remove colleges', 'pedalcms' ),
			'choose_from_most_used'      => __( 'Choose from the most used colleges', 'pedalcms' ),
			'not_found'                  => __( 'No colleges found.', 'pedalcms' ),
			'no_terms'                   => __( 'No colleges', 'pedalcms' ),
			'filter_by_item'             => __( 'Filter by college', 'pedalcms' ),
			'items_list_navigation'      => __( 'Colleges list navigation', 'pedalcms' ),
			'items_list'                 => __( 'Colleges list', 'pedalcms' ),
			'back_to_items'              => __( '&larr; Go to Colleges', 'pedalcms' ),
			'item_link'                  => _x( 'College Link', 'navigation link block title', 'pedalcms' ),
			'item_link_description'      => _x( 'A link to a college.', 'navigation link block description', 'pedalcms' ),
		];
	}
}
