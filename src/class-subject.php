<?php

namespace PedalCMS\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Subject custom taxonomy.
 *
 * @package PedalCMS\Core\ContentModel
 * @since 0.1.0
 */
class Subject extends CustomTaxonomy {
	/**
	 * @inheritdoc
	 */
	public const TAXONOMY = 'pedalcms_subject';

	/**
	 * @inheritdoc
	 */
	public $object_types = [ Course::POST_TYPE ];

	/**
	 * @inheritdoc
	 */
	public array $args = [
		'query_var'         => 'subj',
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
			'name'                       => _x( 'Subjects', 'taxonomy general name', 'pedal-cms' ),
			'singular_name'              => _x( 'Subject', 'taxonomy singular name', 'pedal-cms' ),
			'search_items'               => __( 'Search Subjects', 'pedal-cms' ),
			'popular_items'              => __( 'Popular Subjects', 'pedal-cms' ),
			'all_items'                  => __( 'All Subjects', 'pedal-cms' ),
			'parent_item'                => __( 'Parent Subject', 'pedal-cms' ),
			'parent_item_colon'          => __( 'Parent Subject:', 'pedal-cms' ),
			'edit_item'                  => __( 'Edit Subject', 'pedal-cms' ),
			'view_item'                  => __( 'View Subject', 'pedal-cms' ),
			'update_item'                => __( 'Update Subject', 'pedal-cms' ),
			'add_new_item'               => __( 'Add New Subject', 'pedal-cms' ),
			'new_item_name'              => __( 'New Subject Name', 'pedal-cms' ),
			'separate_items_with_commas' => __( 'Separate subjects with commas', 'pedal-cms' ),
			'add_or_remove_items'        => __( 'Add or remove subjects', 'pedal-cms' ),
			'choose_from_most_used'      => __( 'Choose from the most used subjects', 'pedal-cms' ),
			'not_found'                  => __( 'No subjects found.', 'pedal-cms' ),
			'no_terms'                   => __( 'No subjects', 'pedal-cms' ),
			'filter_by_item'             => __( 'Filter by subject', 'pedal-cms' ),
			'items_list_navigation'      => __( 'Subject list navigation', 'pedal-cms' ),
			'items_list'                 => __( 'Subject list', 'pedal-cms' ),
			'back_to_items'              => __( '&larr; Go to Subjects', 'pedal-cms' ),
			'item_link'                  => _x( 'Subject Link', 'navigation link block title', 'pedal-cms' ),
			'item_link_description'      => _x( 'A link to a subject.', 'navigation link block description', 'pedal-cms' ),
		];
	}
}
