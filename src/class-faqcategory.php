<?php

namespace PedalCMS\Core;

defined( 'ABSPATH' ) || exit;

/**
 * FAQ Category custom taxonomy.
 *
 * @package PedalCMS\Core\ContentModel
 * @since 0.1.0
 */
class FAQCategory extends CustomTaxonomy {
	/**
	 * @inheritdoc
	 */
	public const TAXONOMY = 'pedalcms_faq_cat';

	/**
	 * @inheritdoc
	 */
	public string $name = 'FAQ Category';

	/**
	 * @inheritdoc
	 */
	public string $plural_name = 'FAQ Categories';

	/**
	 * @inheritdoc
	 */
	public $object_types = [ FAQ::POST_TYPE ];

	/**
	 * @inheritdoc
	 */
	public array $args = [
		'query_var'          => 'faq_cat',
		'rewrite'            => false,
		'description'        => '',
		'sort'               => true,
		'hierarchical'       => true,
		'public'             => true,
		'show_ui'            => true,
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
			'name'                       => _x( 'FAQ Categories', 'taxonomy general name', 'pedal-cms' ),
			'singular_name'              => _x( 'FAQ Category', 'taxonomy singular name', 'pedal-cms' ),
			'search_items'               => __( 'Search FAQ Categories', 'pedal-cms' ),
			'popular_items'              => __( 'Popular FAQ Categories', 'pedal-cms' ),
			'all_items'                  => __( 'All FAQ Categories', 'pedal-cms' ),
			'parent_item'                => __( 'Parent FAQ Category', 'pedal-cms' ),
			'parent_item_colon'          => __( 'Parent FAQ Category:', 'pedal-cms' ),
			'edit_item'                  => __( 'Edit FAQ Category', 'pedal-cms' ),
			'view_item'                  => __( 'View FAQ Category', 'pedal-cms' ),
			'update_item'                => __( 'Update FAQ Category', 'pedal-cms' ),
			'add_new_item'               => __( 'Add New FAQ Category', 'pedal-cms' ),
			'new_item_name'              => __( 'New FAQ Category Name', 'pedal-cms' ),
			'separate_items_with_commas' => __( 'Separate FAQ categories with commas', 'pedal-cms' ),
			'add_or_remove_items'        => __( 'Add or remove FAQ categories', 'pedal-cms' ),
			'choose_from_most_used'      => __( 'Choose from the most used FAQ categories', 'pedal-cms' ),
			'not_found'                  => __( 'No FAQ categories found.', 'pedal-cms' ),
			'no_terms'                   => __( 'No FAQ categories', 'pedal-cms' ),
			'filter_by_item'             => __( 'Filter by category', 'pedal-cms' ),
			'items_list_navigation'      => __( 'FAQ Categories list navigation', 'pedal-cms' ),
			'items_list'                 => __( 'FAQ Categories list', 'pedal-cms' ),
			'back_to_items'              => __( '&larr; Go to FAQ Categories', 'pedal-cms' ),
			'item_link'                  => _x( 'FAQ Category Link', 'navigation link block title', 'pedal-cms' ),
			'item_link_description'      => _x( 'A link to a FAQ category.', 'navigation link block description', 'pedal-cms' ),
		];
	}
}
