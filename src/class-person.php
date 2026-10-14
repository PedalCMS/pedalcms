<?php

namespace PedalCMS\Core;

/**
 * Person custom post type.
 *
 * @package PedalCMS\Core\ContentModel
 * @since 0.1.0
 */
class Person extends CustomPostType {
	/**
	 * @inheritdoc
	 */
	public const POST_TYPE = 'pdl_person';

	/**
	 * @inheritdoc
	 */
	public static string $enter_title_text = '';

	/**
	 * @inheritdoc
	 */
	public array $args = [
		'rewrite'         => [ 'slug' => 'directory' ],
		'has_archive'     => 'directory',
		'capability_type' => self::POST_TYPE,
		'menu_icon'       => '',
		'menu_position'   => 5,
		'description'     => '',
		'public'          => true,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'query_var'       => true,
		'map_meta_cap'    => true,
		'hierarchical'    => false,
		'show_in_rest'    => true,
		'supports'        => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
	];

	/**
	 * @inheritdoc
	 */
	public function register(): void {
		$this->args['show_in_rest'] = self::is_block_editor_enabled();

		parent::register();
	}

	/**
	 * @inheritdoc
	 */
	protected function setup_labels(): void {
		static::$enter_title_text = __( 'Enter the Full Name', 'pedal-cms' );

		$this->args['labels'] = [
			'name'                     => _x( 'Personnel', 'post type general name', 'pedal-cms' ),
			'singular_name'            => _x( 'Person', 'post type singular name', 'pedal-cms' ),
			'plural_not_collective'    => _x( 'Personnel', 'post type plural name not collective', 'pedal-cms' ),
			'menu_name'                => __( 'Directory', 'pedal-cms' ),
			'add_new_item'             => __( 'Add New Person', 'pedal-cms' ),
			'edit_item'                => __( 'Edit Person', 'pedal-cms' ),
			'new_item'                 => __( 'New Person', 'pedal-cms' ),
			'view_item'                => __( 'View Person', 'pedal-cms' ),
			'view_items'               => __( 'View Personnel', 'pedal-cms' ),
			'search_items'             => __( 'Search Personnel', 'pedal-cms' ),
			'not_found'                => __( 'No personnel found.', 'pedal-cms' ),
			'not_found_in_trash'       => __( 'No personnel found in Trash.', 'pedal-cms' ),
			'parent_item_colon'        => __( 'Parent Person:', 'pedal-cms' ),
			'all_items'                => __( 'All Personnel', 'pedal-cms' ),
			'archives'                 => __( 'Directory', 'pedal-cms' ),
			'attributes'               => __( 'Person Attributes', 'pedal-cms' ),
			'insert_into_item'         => __( 'Insert into person post', 'pedal-cms' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this person', 'pedal-cms' ),
			'filter_items_list'        => __( 'Filter personnel list', 'pedal-cms' ),
			'items_list_navigation'    => __( 'Personnel list navigation', 'pedal-cms' ),
			'items_list'               => __( 'Personnel list', 'pedal-cms' ),
			'item_published'           => __( 'Person published.', 'pedal-cms' ),
			'item_published_privately' => __( 'Person published privately.', 'pedal-cms' ),
			'item_reverted_to_draft'   => __( 'Person reverted to draft.', 'pedal-cms' ),
			'item_scheduled'           => __( 'Person scheduled.', 'pedal-cms' ),
			'item_updated'             => __( 'Person updated.', 'pedal-cms' ),
			'item_link'                => _x( 'Person Link', 'navigation link block title', 'pedal-cms' ),
			'item_link_description'    => _x( 'A link to a person.', 'navigation link block description', 'pedal-cms' ),
		];
	}

	/**
	 * @inheritdoc
	 */
	protected function setup_template() {
		$this->args['template'] = [
			[
				'core/columns',
				[],
				[
					[
						'core/column',
						[ 'width' => '66.66%' ],
						[
							[ 'pdl/job-title' ],
							[
								'core/paragraph',
								[
									'placeholder' => __( 'Add some bio text …', 'pedal-cms' ),
								],
							],
						],
					],
					[
						'core/column',
						[ 'width' => '33.33%' ],
						[
							[ 'core/post-featured-image' ],
							[ 'pdl/contact-info' ],
						],
					],
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	protected function setup_post_meta() {
		$this->post_meta = [
			'job_title'     => [
				'label'             => __( 'Job Title', 'pedal-cms' ),
				'description'       => __( 'The current position this team member holds', 'pedal-cms' ),
				'type'              => 'string',
				'default'           => '',
				'single'            => true,
				'sanitize_callback' => 'sanitize_text_field',
				'show_in_rest'      => true,
			],
			'office_phone'  => [
				'label'             => __( 'Office Phone', 'pedal-cms' ),
				'description'       => '',
				'type'              => 'string',
				'default'           => '',
				'single'            => true,
				'sanitize_callback' => 'sanitize_text_field',
				'show_in_rest'      => true,
			],
			'email_address' => [
				'label'             => __( 'Email Address', 'pedal-cms' ),
				'description'       => '',
				'type'              => 'string',
				'default'           => '',
				'single'            => true,
				'sanitize_callback' => 'sanitize_email',
				'show_in_rest'      => true,
			],
			'office'        => [
				'label'             => __( 'Office', 'pedal-cms' ),
				'description'       => '',
				'type'              => 'string',
				'default'           => '',
				'single'            => true,
				'sanitize_callback' => 'sanitize_text_field',
				'show_in_rest'      => true,
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function setup_hooks(): void {
		add_action( 'pre_get_posts', [ static::class, 'update_sort_order' ] );
		add_action( 'wp_after_insert_post', [ static::class, 'save_terms' ], 10, 2 );
	}

	/**
	 * Changes the sort order for Person.
	 *
	 * Called on filter: pre_get_posts
	 *
	 * @param WP_Query $query The current WP_Query
	 * @return void
	 */
	public static function update_sort_order( \WP_Query $query ): void {
		$update_order =
			$query->is_main_query() &&
			! is_admin() &&
			! $query->get( 'orderby' ) &&
			$query->is_post_type_archive( self::POST_TYPE );

		if ( $update_order ) {
			$query->set( 'order', 'ASC' );
			$query->set( 'orderby', 'title' );
		}
	}

	/**
	 * A simple wrapper around `Department::save_terms()`
	 *
	 * @see Department::save_terms()
	 *
	 * @param \WP_Post|int $post The post to associate.
	 * @return void
	 */
	public static function save_terms( $post_id, $post ) {
		if ( self::POST_TYPE === $post->post_type ) {
			Department::save_terms( $post );
		}
	}

	/**
	 * Takes a list of People and returns them indexed by category.
	 *
	 * @param array $people A list of People of the type WP_Post.
	 * @return array The category indexed list of people.
	 */
	public static function group_by_category( array $people ): array {
		return self::group_by_tax( $people, PersonCategory::TAXONOMY, 'people' );
	}

	/**
	 * Determines whether the block editor should be enabled for Person.
	 *
	 * @return boolean
	 */
	public static function is_block_editor_enabled(): bool {
		return (bool) Plugin::get_option( 'enable_block_editor_personnel', false );
	}
}
