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
	public const TAXONOMY = 'pdl_program_type';

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
			'name'                       => _x( 'Program Types', 'taxonomy general name', 'pedalcms' ),
			'singular_name'              => _x( 'Program Type', 'taxonomy singular name', 'pedalcms' ),
			'search_items'               => __( 'Search Program Types', 'pedalcms' ),
			'popular_items'              => __( 'Popular Program Types', 'pedalcms' ),
			'all_items'                  => __( 'All Program Types', 'pedalcms' ),
			'parent_item'                => __( 'Parent Program Type', 'pedalcms' ),
			'parent_item_colon'          => __( 'Parent Program Type:', 'pedalcms' ),
			'edit_item'                  => __( 'Edit Program Type', 'pedalcms' ),
			'view_item'                  => __( 'View Program Type', 'pedalcms' ),
			'update_item'                => __( 'Update Program Type', 'pedalcms' ),
			'add_new_item'               => __( 'Add New Program Type', 'pedalcms' ),
			'new_item_name'              => __( 'New Program Type Name', 'pedalcms' ),
			'separate_items_with_commas' => __( 'Separate program types with commas', 'pedalcms' ),
			'add_or_remove_items'        => __( 'Add or remove program types', 'pedalcms' ),
			'choose_from_most_used'      => __( 'Choose from the most used program types', 'pedalcms' ),
			'not_found'                  => __( 'No program types found.', 'pedalcms' ),
			'no_terms'                   => __( 'No program types', 'pedalcms' ),
			'filter_by_item'             => __( 'Filter by program type', 'pedalcms' ),
			'items_list_navigation'      => __( 'Program Type list navigation', 'pedalcms' ),
			'items_list'                 => __( 'Program Type list', 'pedalcms' ),
			'back_to_items'              => __( '&larr; Go to Program Types', 'pedalcms' ),
			'item_link'                  => _x( 'Program Type Link', 'navigation link block title', 'pedalcms' ),
			'item_link_description'      => _x( 'A link to a program type.', 'navigation link block description', 'pedalcms' ),
		];
	}

}
