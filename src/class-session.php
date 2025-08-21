<?php

namespace PedalCMS\Core;

/**
 * Session custom taxonomy.
 *
 * @package PedalCMS\Core\ContentModel
 * @since 0.1.0
 */
class Session extends CustomTaxonomy {
	/**
	 * @inheritdoc
	 */
	public const TAXONOMY = 'pdl_session';

	/**
	 * @inheritdoc
	 */
	public string $name = 'Term';

	/**
	 * @inheritdoc
	 */
	public string $plural_name = 'Terms';

	/**
	 * @inheritdoc
	 */
	public $object_types = [ Course::POST_TYPE ];

	/**
	 * @inheritdoc
	 */
	public array $args = [
		'query_var'         => 'sess',
		'description'       => '',
		'sort'              => true,
		'rewrite'           => false,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => false,
		'show_tagcloud'     => false,
	];

	/**
	 * @inheritdoc
	 */
	protected function setup_labels(): void {
		$this->args['labels'] = [
			'name'                       => _x( 'Sessions', 'taxonomy general name', 'pedalcms' ),
			'singular_name'              => _x( 'Session', 'taxonomy singular name', 'pedalcms' ),
			'search_items'               => __( 'Search Sessions', 'pedalcms' ),
			'popular_items'              => __( 'Popular Sessions', 'pedalcms' ),
			'all_items'                  => __( 'All Sessions', 'pedalcms' ),
			'parent_item'                => __( 'Parent Session', 'pedalcms' ),
			'parent_item_colon'          => __( 'Parent Session:', 'pedalcms' ),
			'edit_item'                  => __( 'Edit Session', 'pedalcms' ),
			'view_item'                  => __( 'View Session', 'pedalcms' ),
			'update_item'                => __( 'Update Session', 'pedalcms' ),
			'add_new_item'               => __( 'Add New Session', 'pedalcms' ),
			'new_item_name'              => __( 'New Session Name', 'pedalcms' ),
			'separate_items_with_commas' => __( 'Separate sessions with commas', 'pedalcms' ),
			'add_or_remove_items'        => __( 'Add or remove sessions', 'pedalcms' ),
			'choose_from_most_used'      => __( 'Choose from the most used sessions', 'pedalcms' ),
			'not_found'                  => __( 'No sessions found.', 'pedalcms' ),
			'no_terms'                   => __( 'No sessions', 'pedalcms' ),
			'filter_by_item'             => __( 'Filter by session', 'pedalcms' ),
			'items_list_navigation'      => __( 'Session list navigation', 'pedalcms' ),
			'items_list'                 => __( 'Session list', 'pedalcms' ),
			'back_to_items'              => __( '&larr; Go to Sessions', 'pedalcms' ),
			'item_link'                  => _x( 'Session Link', 'navigation link block title', 'pedalcms' ),
			'item_link_description'      => _x( 'A link to a session.', 'navigation link block description', 'pedalcms' ),
		];
	}
}
