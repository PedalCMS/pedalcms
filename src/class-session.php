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
	public const TAXONOMY = 'pedalcms_session';

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
			'name'                       => _x( 'Sessions', 'taxonomy general name', 'pedal-cms' ),
			'singular_name'              => _x( 'Session', 'taxonomy singular name', 'pedal-cms' ),
			'search_items'               => __( 'Search Sessions', 'pedal-cms' ),
			'popular_items'              => __( 'Popular Sessions', 'pedal-cms' ),
			'all_items'                  => __( 'All Sessions', 'pedal-cms' ),
			'parent_item'                => __( 'Parent Session', 'pedal-cms' ),
			'parent_item_colon'          => __( 'Parent Session:', 'pedal-cms' ),
			'edit_item'                  => __( 'Edit Session', 'pedal-cms' ),
			'view_item'                  => __( 'View Session', 'pedal-cms' ),
			'update_item'                => __( 'Update Session', 'pedal-cms' ),
			'add_new_item'               => __( 'Add New Session', 'pedal-cms' ),
			'new_item_name'              => __( 'New Session Name', 'pedal-cms' ),
			'separate_items_with_commas' => __( 'Separate sessions with commas', 'pedal-cms' ),
			'add_or_remove_items'        => __( 'Add or remove sessions', 'pedal-cms' ),
			'choose_from_most_used'      => __( 'Choose from the most used sessions', 'pedal-cms' ),
			'not_found'                  => __( 'No sessions found.', 'pedal-cms' ),
			'no_terms'                   => __( 'No sessions', 'pedal-cms' ),
			'filter_by_item'             => __( 'Filter by session', 'pedal-cms' ),
			'items_list_navigation'      => __( 'Session list navigation', 'pedal-cms' ),
			'items_list'                 => __( 'Session list', 'pedal-cms' ),
			'back_to_items'              => __( '&larr; Go to Sessions', 'pedal-cms' ),
			'item_link'                  => _x( 'Session Link', 'navigation link block title', 'pedal-cms' ),
			'item_link_description'      => _x( 'A link to a session.', 'navigation link block description', 'pedal-cms' ),
		];
	}
}
