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
	public const TAXONOMY = 'pedalcms_person_cat';

	/**
	 * @inheritdoc
	 */
	public $object_types = [ Person::POST_TYPE ];

	/**
	 * @inheritdoc
	 */
	public array $args = [
		'query_var'          => 'person_cat',
		'description'        => '',
		'sort'               => true,
		'rewrite'            => [ 'slug' => 'personnel-category' ],
		'hierarchical'       => true,
		'public'             => true,
		'show_ui'            => true,
		'meta_box_cb'        => false,
		'show_in_quick_edit' => true,
		'show_admin_column'  => true,
		'show_in_nav_menus'  => false,
		'show_tagcloud'      => false,
	];

	/**
	 * @inheritdoc
	 */
	protected function setup_labels(): void {
		$this->args['labels'] = [
			'name'                       => _x( 'Personnel Categories', 'taxonomy general name', 'pedal-cms' ),
			'singular_name'              => _x( 'Personnel Category', 'taxonomy singular name', 'pedal-cms' ),
			'search_items'               => __( 'Search Personnel Categories', 'pedal-cms' ),
			'popular_items'              => __( 'Popular Personnel Categories', 'pedal-cms' ),
			'all_items'                  => __( 'All Personnel Categories', 'pedal-cms' ),
			'parent_item'                => __( 'Parent Personnel Category', 'pedal-cms' ),
			'parent_item_colon'          => __( 'Parent Personnel Category:', 'pedal-cms' ),
			'edit_item'                  => __( 'Edit Personnel Category', 'pedal-cms' ),
			'view_item'                  => __( 'View Personnel Category', 'pedal-cms' ),
			'update_item'                => __( 'Update Personnel Category', 'pedal-cms' ),
			'add_new_item'               => __( 'Add New Personnel Category', 'pedal-cms' ),
			'new_item_name'              => __( 'New Personnel Category Name', 'pedal-cms' ),
			'separate_items_with_commas' => __( 'Separate personnel categories with commas', 'pedal-cms' ),
			'add_or_remove_items'        => __( 'Add or remove personnel categories', 'pedal-cms' ),
			'choose_from_most_used'      => __( 'Choose from the most used personnel categories', 'pedal-cms' ),
			'not_found'                  => __( 'No personnel categories found.', 'pedal-cms' ),
			'no_terms'                   => __( 'No personnel categories', 'pedal-cms' ),
			'filter_by_item'             => __( 'Filter by personnel category', 'pedal-cms' ),
			'items_list_navigation'      => __( 'Personnel Category list navigation', 'pedal-cms' ),
			'items_list'                 => __( 'Personnel Category list', 'pedal-cms' ),
			'back_to_items'              => __( '&larr; Go to Personnel Categories', 'pedal-cms' ),
			'item_link'                  => _x( 'Personnel Category Link', 'navigation link block title', 'pedal-cms' ),
			'item_link_description'      => _x( 'A link to a personnel category.', 'navigation link block description', 'pedal-cms' ),
			'none_selected'              => _x( 'Any Category', 'dropdown list none selected', 'pedal-cms' ),
		];
	}
}
