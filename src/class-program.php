<?php

namespace PedalCMS\Core;

/**
 * Program custom post type.
 *
 * @package PedalCMS\Core\ContentModel
 * @since 0.1.0
 */
class Program extends CustomPostType {
	/**
	 * @inheritdoc
	 */
	public const POST_TYPE = 'pedalcms_program';

	private static $subpage_manager = null;

	/**
	 * @inheritdoc
	 */
	public array $args = [
		'has_archive'           => 'programs',
		'rewrite'               => [
			'slug'       => 'program',
			'with_front' => true,
		],
		'capability_type'       => self::POST_TYPE,
		'menu_icon'             => '',
		'menu_position'         => 5,
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => true,
		'show_in_rest'          => true,
		'rest_base'             => 'programs',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'show_ui'               => true,
		'show_in_menu'          => true,
		'query_var'             => 'program',
		'map_meta_cap'          => true,
		'hierarchical'          => false,
		'supports'              => [ 'title', 'thumbnail' ],
	];

	/**
	 * The list of subpages to register.
	 *
	 * Includes subpage ACF field definitions.
	 *
	 * @since 0.1.0
	 *
	 * @var array
	 */
	public static $subpages = [];

	/**
	 * @inheritdoc
	 */
	protected function setup_labels(): void {
		$this->args['labels'] = [
			'name'                     => _x( 'Programs', 'post type general name', 'pedal-cms' ),
			'singular_name'            => _x( 'Program', 'post type singular name', 'pedal-cms' ),
			'menu_name'                => __( 'Pedal', 'pedal-cms' ),
			'add_new_item'             => __( 'Add New Program', 'pedal-cms' ),
			'edit_item'                => __( 'Edit Program', 'pedal-cms' ),
			'new_item'                 => __( 'New Program', 'pedal-cms' ),
			'view_item'                => __( 'View Program', 'pedal-cms' ),
			'view_items'               => __( 'View Programs', 'pedal-cms' ),
			'search_items'             => __( 'Search Programs', 'pedal-cms' ),
			'not_found'                => __( 'No programs found.', 'pedal-cms' ),
			'not_found_in_trash'       => __( 'No programs found in Trash.', 'pedal-cms' ),
			'parent_item_colon'        => __( 'Parent Program:', 'pedal-cms' ),
			'all_items'                => __( 'All Programs', 'pedal-cms' ),
			'archives'                 => __( 'Programs', 'pedal-cms' ),
			'attributes'               => __( 'Program Attributes', 'pedal-cms' ),
			'insert_into_item'         => __( 'Insert into program', 'pedal-cms' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this program', 'pedal-cms' ),
			'filter_items_list'        => __( 'Filter programs list', 'pedal-cms' ),
			'items_list_navigation'    => __( 'Programs list navigation', 'pedal-cms' ),
			'items_list'               => __( 'Programs list', 'pedal-cms' ),
			'item_published'           => __( 'Program published.', 'pedal-cms' ),
			'item_published_privately' => __( 'Program published privately.', 'pedal-cms' ),
			'item_reverted_to_draft'   => __( 'Program reverted to draft.', 'pedal-cms' ),
			'item_scheduled'           => __( 'Program scheduled.', 'pedal-cms' ),
			'item_updated'             => __( 'Program updated.', 'pedal-cms' ),
			'item_link'                => _x( 'Program Link', 'navigation link block title', 'pedal-cms' ),
			'item_link_description'    => _x( 'A link to a program.', 'navigation link block description', 'pedal-cms' ),
		];
	}

	/**
	 * Initialize the list of Subpages.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	protected static function setup_subpages() {
		self::$subpages = [
			'index'         => [
				'title'   => _x( 'Overview', 'Proper subpage title', 'pedal-cms' ),
				'order'   => -1,
				'builtin' => true,
			],
			'curriculum'    => [
				'title'   => _x( 'Curriculum', 'Proper subpage title', 'pedal-cms' ),
				'order'   => 10,
				'builtin' => true,
				'fields'  => [
					[
						'key'                 => 'field_6112835dfeb44',
						'label'               => __( 'Show Curriculum Section?', 'pedal-cms' ),
						'name'                => 'pedalcms_show_curriculum_section',
						'type'                => 'true_false',
						'instructions'        => '',
						'message'             => '',
						'default_value'       => true,
						'ui'                  => 1,
						'ui_on_text'          => '',
						'ui_off_text'         => '',
						'wpml_cf_preferences' => 1,
					],
					[
						'key'           => 'field_615f0ea5ecd84',
						'label'         => _x( 'Lead Content', 'Curriculum', 'pedal-cms' ),
						'name'          => 'pedalcms_curriculum_lead',
						'type'          => 'wysiwyg',
						'instructions'  => __( 'This content goes before the list of curriculum sections.', 'pedal-cms' ),
						'default_value' => '',
						'tabs'          => 'all',
						'toolbar'       => 'full',
						'media_upload'  => 1,
						'delay'         => 1,
					],
					[
						'key'          => 'field_615f0c5a22deb',
						'label'        => __( 'Curriculum Sections', 'pedal-cms' ),
						'name'         => 'pedalcms_curriculum_sections',
						'type'         => 'repeater',
						'instructions' => '',
						'collapsed'    => 'field_615f0c8022dec',
						'layout'       => 'block',
						'button_label' => _x( 'Add Section', 'New section button label', 'pedal-cms' ),
						'sub_fields'   => [
							[
								'key'          => 'field_615f0c8022dec',
								'label'        => __( 'Section Title', 'pedal-cms' ),
								'name'         => 'section_title',
								'type'         => 'text',
								'instructions' => '',
								'placeholder'  => __( 'Math Requirements, etc.', 'pedal-cms' ),
								'prepend'      => '',
								'append'       => '',
								'maxlength'    => '',
							],
							[
								'key'               => 'field_615f0cd622ded',
								'label'             => __( 'Section Content', 'pedal-cms' ),
								'name'              => 'section_content',
								'type'              => 'wysiwyg',
								'instructions'      => __( 'Some preamble or instructions about the courses below. For example, "Choose two of the following."', 'pedal-cms' ),
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => [
									'width' => '',
									'class' => '',
									'id'    => '',
								],
								'tabs'              => 'all',
								'toolbar'           => 'full',
								'media_upload'      => 0,
								'delay'             => 1,
							],
							[
								'key'           => 'field_615f0d7322dee',
								'label'         => __( 'Section Courses', 'pedal-cms' ),
								'name'          => 'section_courses',
								'type'          => 'relationship',
								'instructions'  => '',
								'post_type'     => [
									0 => 'pedalcms_course',
								],
								'filters'       => [
									0 => 'search',
									1 => 'taxonomy',
								],
								'return_format' => 'object',
							],
						],
					],
				],
			],
			'careers'       => [
				'title'      => _x( 'Careers', 'Proper subpage title', 'pedal-cms' ),
				'aria_label' => __( 'Careers related to the current program', 'pedal-cms' ),
				'order'      => 20,
				'builtin'    => true,
				'fields'     => [
					[
						'key'                 => 'field_61118a6ecb6c0',
						'label'               => __( 'Show Careers Section?', 'pedal-cms' ),
						'name'                => 'pedalcms_show_careers_section',
						'type'                => 'true_false',
						'instructions'        => '',
						'message'             => '',
						'default_value'       => true,
						'ui'                  => 1,
						'ui_on_text'          => '',
						'ui_off_text'         => '',
						'wpml_cf_preferences' => 1,
					],
					[
						'key'           => 'field_611275a9d4b74',
						'label'         => _x( 'Lead Content', 'Careers', 'pedal-cms' ),
						'name'          => 'pedalcms_careers_lead',
						'type'          => 'wysiwyg',
						'instructions'  => '',
						'default_value' => '',
						'tabs'          => 'all',
						'toolbar'       => 'full',
						'media_upload'  => 1,
						'delay'         => 1,
					],
					[
						'key'           => 'field_6112754dd4b73',
						'label'         => __( 'Related Careers', 'pedal-cms' ),
						'name'          => 'pedalcms_related_program_careers',
						'type'          => 'relationship',
						'instructions'  => '',
						'post_type'     => [
							0 => 'pedalcms_career',
						],
						'taxonomy'      => '',
						'filters'       => [
							0 => 'search',
							1 => 'taxonomy',
						],
						'elements'      => '',
						'min'           => '',
						'max'           => '',
						'return_format' => 'object',
					],
				],
			],
			'faculty-staff' => [
				'title'      => _x( 'Faculty & Staff', 'Proper subpage title', 'pedal-cms' ),
				'aria_label' => __( 'Faculty & staff related to the current program', 'pedal-cms' ),
				'order'      => 30,
				'builtin'    => true,
				'fields'     => [
					[
						'key'                 => 'field_613b63fa499ce',
						'label'               => __( 'Show Faculty & Staff Section?', 'pedal-cms' ),
						'name'                => 'pedalcms_show_faculty_staff_section',
						'type'                => 'true_false',
						'instructions'        => '',
						'message'             => '',
						'default_value'       => true,
						'ui'                  => 1,
						'ui_on_text'          => '',
						'ui_off_text'         => '',
						'wpml_cf_preferences' => 1,
					],
					[
						'key'           => 'field_613b6446aae76',
						'label'         => _x( 'Lead Content', 'Faculty & Staff', 'pedal-cms' ),
						'name'          => 'pedalcms_faculty_staff_lead',
						'type'          => 'wysiwyg',
						'instructions'  => '',
						'default_value' => '',
						'tabs'          => 'all',
						'toolbar'       => 'full',
						'media_upload'  => 1,
						'delay'         => 1,
					],
					[
						'key'                 => 'field_613b6ecd4687a',
						'label'               => __( 'Group by category?', 'pedal-cms' ),
						'name'                => 'pedalcms_faculty_staff_by_category',
						'type'                => 'true_false',
						'instructions'        => '',
						'message'             => '',
						'default_value'       => true,
						'ui'                  => 1,
						'ui_on_text'          => '',
						'ui_off_text'         => '',
						'wpml_cf_preferences' => 1,
					],
					[
						'key'           => 'field_613b6de416aa1',
						'label'         => __( 'Related Faculty & Staff', 'pedal-cms' ),
						'name'          => 'pedalcms_related_faculty_staff',
						'type'          => 'relationship',
						'instructions'  => '',
						'post_type'     => [
							0 => 'pedalcms_person',
						],
						'taxonomy'      => '',
						'filters'       => [
							0 => 'search',
						],
						'elements'      => [
							0 => 'featured_image',
						],
						'min'           => '',
						'max'           => '',
						'return_format' => 'object',
					],
				],
			],
			'cost'          => [
				'title'   => _x( 'Cost', 'Proper subpage title', 'pedal-cms' ),
				'order'   => 40,
				'builtin' => true,
				'fields'  => [
					[
						'key'                 => 'field_6124eebb8a99e',
						'label'               => __( 'Show Cost Section?', 'pedal-cms' ),
						'name'                => 'pedalcms_show_cost_section',
						'type'                => 'true_false',
						'instructions'        => '',
						'message'             => '',
						'default_value'       => true,
						'ui'                  => 1,
						'ui_on_text'          => '',
						'ui_off_text'         => '',
						'wpml_cf_preferences' => 1,
					],
					[
						'key'          => 'field_617848545496b',
						'label'        => __( 'Estimated Cost Label', 'pedal-cms' ),
						'name'         => 'pedalcms_estimated_cost_label',
						'type'         => 'text',
						'instructions' => '',
						'placeholder'  => _x( 'Estimated Cost', 'field placeholder', 'pedal-cms' ),
					],
					[
						'key'          => 'field_6178492a5496c',
						'label'        => _x( 'Estimated Cost', 'field label', 'pedal-cms' ),
						'name'         => 'pedalcms_estimated_cost',
						'type'         => 'text',
						'instructions' => __( 'Leave blank to omit this field.', 'pedal-cms' ),
					],
					[
						'key'           => 'field_61327ef17bf0d',
						'label'         => __( 'Cost Content', 'pedal-cms' ),
						'name'          => 'pedalcms_cost_content',
						'type'          => 'wysiwyg',
						'instructions'  => '',
						'default_value' => '',
						'tabs'          => 'all',
						'toolbar'       => 'full',
						'media_upload'  => 1,
						'delay'         => 1,
					],
				],
			],
			'apply'         => [
				'title'   => _x( 'How to Apply', 'Proper subpage title', 'pedal-cms' ),
				'order'   => 50,
				'builtin' => true,
				'fields'  => [
					[
						'key'                 => 'field_611d69fb7f47f',
						'label'               => __( 'Show Apply Section?', 'pedal-cms' ),
						'name'                => 'pedalcms_show_apply_section',
						'type'                => 'true_false',
						'instructions'        => '',
						'message'             => '',
						'default_value'       => true,
						'ui'                  => 1,
						'ui_on_text'          => '',
						'ui_off_text'         => '',
						'wpml_cf_preferences' => 1,
					],
					[
						'key'           => 'field_611d6bfe199d9',
						'label'         => __( 'Apply Content', 'pedal-cms' ),
						'name'          => 'pedalcms_apply_content',
						'type'          => 'wysiwyg',
						'instructions'  => '',
						'default_value' => '',
						'tabs'          => 'all',
						'toolbar'       => 'full',
						'media_upload'  => 1,
						'delay'         => 1,
					],
				],
			],
			'faqs'          => [
				'title'      => _x( 'FAQs', 'Proper subpage title', 'pedal-cms' ),
				'aria_label' => __( 'FAQs related to the current program', 'pedal-cms' ),
				'order'      => 60,
				'builtin'    => true,
				'fields'     => [
					[
						'key'                 => 'field_61118aa8cb6c2',
						'label'               => __( 'Show FAQs Section?', 'pedal-cms' ),
						'name'                => 'pedalcms_show_faqs_section',
						'type'                => 'true_false',
						'instructions'        => '',
						'message'             => '',
						'default_value'       => true,
						'ui'                  => 1,
						'ui_on_text'          => '',
						'ui_off_text'         => '',
						'wpml_cf_preferences' => 1,
					],
					[
						'key'                 => 'field_6113d61abfe26',
						'label'               => __( 'Group FAQs by category?', 'pedal-cms' ),
						'name'                => 'pedalcms_faqs_by_category',
						'type'                => 'true_false',
						'instructions'        => '',
						'message'             => '',
						'default_value'       => true,
						'ui'                  => 1,
						'ui_on_text'          => '',
						'ui_off_text'         => '',
						'wpml_cf_preferences' => 1,
					],
					[
						'key'           => 'field_6112760bd4b75',
						'label'         => _x( 'Lead Content', 'FAQs', 'pedal-cms' ),
						'name'          => 'pedalcms_faqs_lead',
						'type'          => 'wysiwyg',
						'instructions'  => '',
						'default_value' => '',
						'tabs'          => 'all',
						'toolbar'       => 'full',
						'media_upload'  => 1,
						'delay'         => 1,
					],
					[
						'key'          => 'field_61701a9d36062',
						'label'        => __( 'Related FAQs', 'pedal-cms' ),
						'name'         => 'pedalcms_related_faqs_list',
						'type'         => 'repeater',
						'instructions' => '',
						'collapsed'    => 'field_61701ac036063',
						'layout'       => 'row',
						'button_label' => _x( 'Add Question', 'new question button label', 'pedal-cms' ),
						'sub_fields'   => [
							[
								'key'           => 'field_61701ac036063',
								'label'         => __( 'FAQ Type', 'pedal-cms' ),
								'name'          => 'faq_type',
								'type'          => 'radio',
								'instructions'  => __( 'Select the type of FAQ you would like to add.', 'pedal-cms' ),
								'required'      => 1,
								'layout'        => 'vertical',
								'return_format' => 'value',
								'choices'       => [
									'global' => 'Global',
									'local'  => 'Program Specific',
								],
							],
							[
								'key'               => 'field_61701bf236064',
								'label'             => _x( 'Global FAQ', 'faqs relevant to all programs', 'pedal-cms' ),
								'name'              => 'faq_post',
								'type'              => 'post_object',
								'instructions'      => __( 'Select the global question.', 'pedal-cms' ),
								'required'          => 1,
								'taxonomy'          => '',
								'allow_null'        => 0,
								'multiple'          => 0,
								'return_format'     => 'object',
								'ui'                => 1,
								'post_type'         => [
									0 => 'pedalcms_faq',
								],
								'conditional_logic' => [
									[
										[
											'field'    => 'field_61701ac036063',
											'operator' => '==',
											'value'    => 'global',
										],
									],
								],
							],
							[
								'key'               => 'field_61701c8536065',
								'label'             => __( 'Question', 'pedal-cms' ),
								'name'              => 'question',
								'type'              => 'text',
								'instructions'      => __( 'Enter the question text.', 'pedal-cms' ),
								'placeholder'       => _x( 'What is the question?', 'question field placeholder', 'pedal-cms' ),
								'required'          => 1,
								'conditional_logic' => [
									[
										[
											'field'    => 'field_61701ac036063',
											'operator' => '==',
											'value'    => 'local',
										],
									],
								],
							],
							[
								'key'               => 'field_61701cc336066',
								'label'             => __( 'Answer', 'pedal-cms' ),
								'name'              => 'answer',
								'type'              => 'wysiwyg',
								'instructions'      => '',
								'required'          => 1,
								'default_value'     => '',
								'tabs'              => 'all',
								'toolbar'           => 'basic',
								'media_upload'      => 0,
								'delay'             => 1,
								'conditional_logic' => [
									[
										[
											'field'    => 'field_61701ac036063',
											'operator' => '==',
											'value'    => 'local',
										],
									],
								],
							],
							[
								'key'               => 'field_61701cf336067',
								'label'             => __( 'Category', 'pedal-cms' ),
								'name'              => 'faq_category',
								'type'              => 'taxonomy',
								'instructions'      => '',
								'required'          => 1,
								'taxonomy'          => 'pedalcms_faq_cat',
								'field_type'        => 'select',
								'allow_null'        => 0,
								'add_term'          => 0,
								'save_terms'        => 0,
								'load_terms'        => 0,
								'return_format'     => 'object',
								'multiple'          => 0,
								'conditional_logic' => [
									[
										[
											'field'    => 'field_6113d61abfe26',
											'operator' => '==',
											'value'    => '1',
										],
										[
											'field'    => 'field_61701ac036063',
											'operator' => '==',
											'value'    => 'local',
										],
									],
								],
							],
						],
					],
				],
			],
			'news'          => [
				'title'      => _x( 'News', 'Proper subpage title', 'pedal-cms' ),
				'aria_label' => __( 'News related to the current program', 'pedal-cms' ),
				'order'      => 70,
				'builtin'    => true,
				'fields'     => [
					[
						'key'                 => 'field_611fdfdc20be6',
						'label'               => __( 'Show News Section?', 'pedal-cms' ),
						'name'                => 'pedalcms_show_news_section',
						'type'                => 'true_false',
						'instructions'        => '',
						'message'             => '',
						'default_value'       => true,
						'ui'                  => 1,
						'ui_on_text'          => '',
						'ui_off_text'         => '',
						'wpml_cf_preferences' => 1,
					],
					[
						'key'           => 'field_611fe01c20be7',
						'label'         => _x( 'News Tag', 'tag of related news', 'pedal-cms' ),
						'name'          => 'pedalcms_news_tag',
						'type'          => 'taxonomy',
						'instructions'  => __( 'The tag that should associate posts with this program.', 'pedal-cms' ),
						'taxonomy'      => 'post_tag',
						'field_type'    => 'select',
						'allow_null'    => 1,
						'add_term'      => 1,
						'save_terms'    => 0,
						'load_terms'    => 0,
						'return_format' => 'id',
						'multiple'      => 0,
						'wrapper'       => [
							'width' => '33',
							'class' => '',
							'id'    => '',
						],
					],
					[
						'key'           => 'field_6124f029ff016',
						'label'         => __( 'Number of Posts', 'pedal-cms' ),
						'name'          => 'pedalcms_news_num_posts',
						'type'          => 'number',
						'instructions'  => __( 'Number of posts to show on this subpage. Set to -1 to show all.', 'pedal-cms' ),
						'default_value' => 10,
						'placeholder'   => '10',
						'min'           => -1,
						'step'          => 1,
						'wrapper'       => [
							'width' => '33',
							'class' => '',
							'id'    => '',
						],
					],
					[
						'key'                 => 'field_6124f184ff017',
						'label'               => __( 'Show link to all posts?', 'pedal-cms' ),
						'name'                => 'pedalcms_news_show_all_link',
						'type'                => 'true_false',
						'instructions'        => __( 'Link to the tag archive view at the bottom of the list?', 'pedal-cms' ),
						'default_value'       => 1,
						'ui'                  => 1,
						'wrapper'             => [
							'width' => '33',
							'class' => '',
							'id'    => '',
						],
						'wpml_cf_preferences' => 1,
					],
					[
						'key'           => 'field_61263568d2f46',
						'label'         => __( 'Featured Posts', 'pedal-cms' ),
						'name'          => 'pedalcms_news_featured_posts',
						'type'          => 'post_object',
						'instructions'  => __( 'Select posts to keep at the top of the news subpage.', 'pedal-cms' ),
						'post_type'     => [
							0 => 'post',
						],
						'allow_null'    => 1,
						'multiple'      => 1,
						'return_format' => 'object',
						'ui'            => 1,
					],
					[
						'key'           => 'field_611fdfd220be5',
						'label'         => _x( 'Lead Content', 'News', 'pedal-cms' ),
						'name'          => 'pedalcms_news_lead',
						'type'          => 'wysiwyg',
						'instructions'  => __( 'Content to appear at the top of the page, before the posts.', 'pedal-cms' ),
						'default_value' => '',
						'tabs'          => 'all',
						'toolbar'       => 'full',
						'media_upload'  => 1,
						'delay'         => 1,
					],
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function setup_hooks(): void {
		//Remove custom fields support for this post type.
		remove_post_type_support( static::POST_TYPE, 'custom-fields' );

		add_action( 'pre_get_posts', [ static::class, 'update_sort_order' ] );
		add_action( 'wp_after_insert_post', [ static::class, 'save_terms' ], 10, 2 );
	}

	/**
	 * Changes the sort order for Programs.
	 *
	 * Called on filter: pre_get_posts
	 *
	 * @since 0.1.0
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
	 * Associates a post with the appropriate department terms.
	 *
	 * @since 0.1.0
	 *
	 * @param int $post_id The current post ID.
	 * @param \WP_Post $post The current post object.
	 * @return void
	 */
	public static function save_terms( $post_id, $post ) {
		if ( self::POST_TYPE === $post->post_type ) {
			Department::save_terms( $post );
		}
	}

	/**
	 * Get the news posts for a given program by related tag.
	 *
	 * Meta field news_tag must be set first.
	 *
	 * @since 0.1.0
	 *
	 * @param mixed $program Program to check for news posts. Either ID or WP_Post.
	 * @param array $not_in List of ids to exclude from the results. Defaults to none.
	 * @return array List of WP_Posts that match the Program's tag.
	 */
	public static function get_related_posts( $program = null, array $not_in = [] ): array {
		$program = get_post( $program );

		$tag       = get_post_meta( $program->ID, 'pedalcms_news_tag', true );
		$num_posts = get_post_meta( $program->ID, 'pedalcms_news_num_posts', true );

		if ( ! $tag ) {
			return [];
		}

		$args = [
			'tag_id'              => $tag,
			'ignore_sticky_posts' => true,
			'posts_per_page'      => $num_posts,
		];

		if ( ! empty( $not_in ) ) {
			$args['post__not_in'] = $not_in; // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_post__not_in -- Small, bounded exclusion list for related posts.
		}

		return get_posts( $args );
	}

	/**
	 * Returns the full URL for a given program action.
	 *
	 * Will check for a local program override before attempting to build it from
	 * the plugin wide pattern setting.
	 *
	 * @since 0.1.0
	 *
	 * @param string $action The name of the action.
	 * @param mixed $program The ID of the program or a WP_Post object. Defaults to the current program.
	 * @return string The URL of the program action.
	 */
	public static function get_action_link( string $action, $program = null ): string {
		$program = get_post( $program );

		// Check for a local override.
		$url = get_post_meta( $program->ID, 'pedalcms_url_' . $action, true );

		if ( $url ) {
			return $url;
		}

		$url = \PedalCMS\Core\Plugin::get_option( 'program_url_' . $action );

		if ( $url ) {
			$url = str_replace(
				[ '{$program_guid}', '{$program_slug}' ],
				[ (string) get_post_meta( $program->ID, 'pedalcms_program_guid', true ), $program->post_name ],
				$url
			);

			return $url;
		}

		return '';
	}

	/**
	 * Gets a list of application deadlines based on override hierarchy.
	 *
	 * Hierarchy is Program, College, Program Type, Global.
	 *
	 * @since 0.1.0
	 *
	 * @param mixed $program Program to check for news posts. Either ID or WP_Post. Defaults to current program.
	 * @return array An ACF repeater field with deadline_label and deadline_info subfields.
	 */
	public static function get_application_deadlines( $program = null ): array {
		$program = get_post( $program );

		// First, check if the program has specific deadlines.
		$deadlines = get_post_meta( $program->ID, 'pedalcms_application_deadlines', true );

		if ( ! empty( $deadlines ) ) {
			return $deadlines;
		}

		// Then, check if either the college or the program type has overriden.
		$terms = [ 'pedalcms_college', 'pedalcms_program_type' ];

		foreach ( $terms as $name ) {
			$term_id = (int) get_post_meta( $program->ID, $name, true );

			if ( ! empty( $term_id ) ) {
				$deadlines = get_term_meta( $term_id, 'pedalcms_application_deadlines', true );

				if ( ! empty( $deadlines ) ) {
					return $deadlines;
				}
			}
		}

		// If all else fails, just return the global setting.
		$deadlines = Plugin::get_option( 'program_application_deadlines' );
		if ( is_array( $deadlines ) ) {
			return $deadlines;
		}

		return [];
	}

	/**
	 * Initializes the subpage manager and adds builtin subpages.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public static function setup_subpage_manager() {
		self::setup_subpages();
		self::$subpage_manager = new SubpageManager( self::POST_TYPE );

		do_action( 'pedalcms/register_subpages', self::POST_TYPE );

		foreach ( self::$subpages as $slug => $args ) {
			$subpage = new Subpage( $slug, $args );
			self::$subpage_manager->add_subpage( $subpage );
		}
	}

	/**
	 * Returns the subpage manager.
	 *
	 * @since 0.1.0
	 *
	 * @return SubpageManager The program subpage manager.
	 */
	public static function subpage_manager() {
		return self::$subpage_manager;
	}
}
