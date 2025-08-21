<?php

namespace PedalCMS\Core;

/**
 * Department custom taxonomy.
 *
 * @package PedalCMS\Core\ContentModel
 * @since 0.1.0
 */
class Department extends CustomTaxonomy {
	/**
	 * @inheritdoc
	 */
	public const TAXONOMY = 'pdl_department';

	/**
	 * @inheritdoc
	 */
	public $object_types = [ Program::POST_TYPE, Person::POST_TYPE, Course::POST_TYPE ];

	/**
	 * @inheritdoc
	 */
	public array $args = [
		'query_var'          => 'dept',
		'description'        => '',
		'sort'               => [ 'slug' => 'department' ],
		'rewrite'            => false,
		'hierarchical'       => false,
		'public'             => true,
		'show_ui'            => true,
		'meta_box_cb'        => false,
		'show_in_quick_edit' => false,
		'show_admin_column'  => true,
		'show_in_nav_menus'  => true,
		'show_tagcloud'      => false,
	];

	/**
	 * @inheritdoc
	 */
	protected function setup_labels(): void {
		$this->args['labels'] = [
			'name'                       => _x( 'Departments', 'taxonomy general name', 'pedalcms' ),
			'singular_name'              => _x( 'Department', 'taxonomy singular name', 'pedalcms' ),
			'search_items'               => __( 'Search Departments', 'pedalcms' ),
			'popular_items'              => __( 'Popular Departments', 'pedalcms' ),
			'all_items'                  => __( 'All Departments', 'pedalcms' ),
			'parent_item'                => __( 'Parent Department', 'pedalcms' ),
			'parent_item_colon'          => __( 'Parent Department:', 'pedalcms' ),
			'edit_item'                  => __( 'Edit Department', 'pedalcms' ),
			'view_item'                  => __( 'View Department', 'pedalcms' ),
			'update_item'                => __( 'Update Department', 'pedalcms' ),
			'add_new_item'               => __( 'Add New Department', 'pedalcms' ),
			'new_item_name'              => __( 'New Department Name', 'pedalcms' ),
			'separate_items_with_commas' => __( 'Separate departments with commas', 'pedalcms' ),
			'add_or_remove_items'        => __( 'Add or remove departments', 'pedalcms' ),
			'choose_from_most_used'      => __( 'Choose from the most used departments', 'pedalcms' ),
			'not_found'                  => __( 'No departments found.', 'pedalcms' ),
			'no_terms'                   => __( 'No departments', 'pedalcms' ),
			'filter_by_item'             => __( 'Filter by category', 'pedalcms' ),
			'items_list_navigation'      => __( 'Departments list navigation', 'pedalcms' ),
			'items_list'                 => __( 'Departments list', 'pedalcms' ),
			'back_to_items'              => __( '&larr; Go to Departments', 'pedalcms' ),
			'item_link'                  => _x( 'Department Link', 'navigation link block title', 'pedalcms' ),
			'item_link_description'      => _x( 'A link to a department.', 'navigation link block description', 'pedalcms' ),
		];
	}

	/**
	 * @inheritdoc
	 */
	protected function setup_field_group() {
		$field_group = [
			'key'                   => 'group_630e244b8c660',
			'title'                 => __( 'Department Info', 'pedalcms' ),
			'menu_order'            => 0,
			'position'              => 'acf_after_title',
			'style'                 => 'seamless',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
			'description'           => '',
			'location'              => [
				[
					[
						'param'    => 'taxonomy',
						'operator' => '==',
						'value'    => static::TAXONOMY,
					],
				],
			],
			'fields'                => [
				[
					'key'               => 'field_630faf40e6008',
					'label'             => 'College',
					'name'              => 'college',
					'type'              => 'taxonomy',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '',
						'class' => '',
						'id'    => '',
					],
					'taxonomy'          => 'pdl_college',
					'add_term'          => 0,
					'save_terms'        => 0,
					'load_terms'        => 0,
					'return_format'     => 'id',
					'field_type'        => 'select',
					'allow_null'        => 0,
					'multiple'          => 0,
				],
				[
					'key'           => 'field_6304c88d7d4aa',
					'label'         => __( 'Featured Image', 'pedalcms' ),
					'name'          => 'featured_image',
					'type'          => 'image',
					'instructions'  => '',
					'return_format' => 'url',
					'preview_size'  => 'medium',
					'library'       => 'all',
				],
				[
					'key'               => 'field_630e13fdc975c',
					'label'             => __( 'Header Background Image', 'pedalcms' ),
					'name'              => 'header_background',
					'type'              => 'image',
					'instructions'      => __( 'The background image of the archive page header (Tuxedo Mode only).', 'pedalcms' ),
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '',
						'class' => 'present-mode-full',
						'id'    => '',
					],
					'return_format'     => 'id',
					'preview_size'      => 'medium',
					'library'           => 'all',
					'min_width'         => '',
					'min_height'        => '',
					'min_size'          => '',
					'max_width'         => '',
					'max_height'        => '',
					'max_size'          => '',
					'mime_types'        => '',
				],
			],
		];

		$this->field_groups[] = $field_group;
	}

	/**
	 * Determines whether departments depend on colleges based on user settings.
	 *
	 * @return bool Whether departments depend on colleges.
	 */
	public static function depends_on_college(): bool {
		return Plugin::get_option( 'college_enable' ) &&
			Plugin::get_option( 'department_depends_college' );
	}

	/**
	 * Gets all departments associated with a given college.
	 *
	 * @param \WP_Term|int $term A WP_Term or term ID object representing the college.
	 * @return \WP_Term[]|WP_Error|false Array of WP_Term objects on success, false if not found, WP_Error otherwise.
	 */
	public static function get_by_college( $term ) {
		$term = get_term( $term, College::TAXONOMY );

		if ( $term && ! is_wp_error( $term ) ) {
			return self::get_by_meta( 'college', $term->term_id );
		}

		return new WP_Error(
			'pdl_not_found',
			__( 'The requested college was not found', 'pedalcms' )
		);
	}

	/**
	 * Creates the post/taxonomy connection to the given post from the `department` field.
	 *
	 * @param \WP_Post|int $post The post to associate.
	 * @return void
	 */
	public static function save_terms( $post = null ) {
		$post    = get_post( $post );
		$term_id = get_field( 'department', $post );

		if ( $term_id ) {
			wp_set_object_terms( $post->ID, (int) $term_id, self::TAXONOMY, false );
		}
	}
}
