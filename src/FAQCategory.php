<?php

namespace PedalCMS\Core;

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
	public const TAXONOMY = 'pdl_faq_cat';

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
		'rewrite'            => false,
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
			'name'                       => _x( 'FAQ Categories', 'taxonomy general name', 'pedalcms' ),
			'singular_name'              => _x( 'FAQ Category', 'taxonomy singular name', 'pedalcms' ),
			'search_items'               => __( 'Search FAQ Categories', 'pedalcms' ),
			'popular_items'              => __( 'Popular FAQ Categories', 'pedalcms' ),
			'all_items'                  => __( 'All FAQ Categories', 'pedalcms' ),
			'parent_item'                => __( 'Parent FAQ Category', 'pedalcms' ),
			'parent_item_colon'          => __( 'Parent FAQ Category:', 'pedalcms' ),
			'edit_item'                  => __( 'Edit FAQ Category', 'pedalcms' ),
			'view_item'                  => __( 'View FAQ Category', 'pedalcms' ),
			'update_item'                => __( 'Update FAQ Category', 'pedalcms' ),
			'add_new_item'               => __( 'Add New FAQ Category', 'pedalcms' ),
			'new_item_name'              => __( 'New FAQ Category Name', 'pedalcms' ),
			'separate_items_with_commas' => __( 'Separate FAQ categories with commas', 'pedalcms' ),
			'add_or_remove_items'        => __( 'Add or remove FAQ categories', 'pedalcms' ),
			'choose_from_most_used'      => __( 'Choose from the most used FAQ categories', 'pedalcms' ),
			'not_found'                  => __( 'No FAQ categories found.', 'pedalcms' ),
			'no_terms'                   => __( 'No FAQ categories', 'pedalcms' ),
			'filter_by_item'             => __( 'Filter by category', 'pedalcms' ),
			'items_list_navigation'      => __( 'FAQ Categories list navigation', 'pedalcms' ),
			'items_list'                 => __( 'FAQ Categories list', 'pedalcms' ),
			'back_to_items'              => __( '&larr; Go to FAQ Categories', 'pedalcms' ),
			'item_link'                  => _x( 'FAQ Category Link', 'navigation link block title', 'pedalcms' ),
			'item_link_description'      => _x( 'A link to a FAQ category.', 'navigation link block description', 'pedalcms' ),
		];
	}
}
