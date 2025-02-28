<?php

namespace PedalCMS\Core;

/**
 * Person custom post type.
 *
 * @package NVISPrograms
 * @subpackage ContentModel
 * @since 0.1.0
 */
class Person extends CustomPostType {
    /**
     * The post type to register.
     */
    public const POST_TYPE = 'pdl_person';

    /**
     * The args to pass to register_post_type.
     *
     * Gets updated throughout the setup process.
     *
     * @var array
     */
    public array $args = [
        'rewrite'             => ['slug' => 'directory'],
        'has_archive'         => 'directory',
        'capability_type'     => self::POST_TYPE,
        'menu_icon'           => 'dashicons-businesswoman',
        'menu_position'       => 5,
        'description'         => '',
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'show_in_rest'        => true,
        'supports'            => ['title', 'editor', 'thumbnail', 'custom-fields'],
    ];

    public function register(): void {
        if (!self::is_block_editor_enabled()) {
            $this->args['show_in_rest'] = false;
        }

        parent::register();
    }

    protected function setup_labels(): void {
        self::$enter_title_text = __('Enter the Full Name', 'pedalcms');

        $this->args['labels'] = [
            'name'                     => _x( 'Directory', 'post type general name', 'pedalcms' ),
            'singular_name'            => _x( 'Person', 'post type singular name', 'pedalcms' ),
            'plural_not_collective'    => _x( 'Personnel', 'post type plural name not collective', 'pedalcms' ),
            'add_new_item'             => __( 'Add New Person', 'pedalcms' ),
            'edit_item'                => __( 'Edit Person', 'pedalcms' ),
            'new_item'                 => __( 'New Person', 'pedalcms' ),
            'view_item'                => __( 'View Person', 'pedalcms' ),
            'view_items'               => __( 'View Personnel', 'pedalcms' ),
            'search_items'             => __( 'Search Personnel', 'pedalcms' ),
            'not_found'                => __( 'No personnel found.', 'pedalcms' ),
            'not_found_in_trash'       => __( 'No personnel found in Trash.', 'pedalcms' ),
            'parent_item_colon'        => __( 'Parent Person:', 'pedalcms' ),
            'all_items'                => __( 'All Personnel', 'pedalcms' ),
            'archives'                 => __( 'Directory', 'pedalcms' ),
            'attributes'               => __( 'Person Attributes', 'pedalcms' ),
            'insert_into_item'         => __( 'Insert into person post', 'pedalcms' ),
            'uploaded_to_this_item'    => __( 'Uploaded to this person', 'pedalcms' ),
            'filter_items_list'        => __( 'Filter personnel list', 'pedalcms' ),
            'items_list_navigation'    => __( 'Personnel list navigation', 'pedalcms' ),
            'items_list'               => __( 'Personnel list', 'pedalcms' ),
            'item_published'           => __( 'Person published.', 'pedalcms' ),
            'item_published_privately' => __( 'Person published privately.', 'pedalcms' ),
            'item_reverted_to_draft'   => __( 'Person reverted to draft.', 'pedalcms' ),
            'item_scheduled'           => __( 'Person scheduled.', 'pedalcms' ),
            'item_updated'             => __( 'Person updated.', 'pedalcms' ),
            'item_link'                => _x( 'Person Link', 'navigation link block title', 'pedalcms' ),
            'item_link_description'    => _x( 'A link to a person.', 'navigation link block description', 'pedalcms' ),
        ];
    }

    protected function setup_template() {
        $this->args['template'] = [
            [ 'core/columns', [], [
                [ 'core/column', ['width' => '66.66%'], [
                    ['pdl/job-title'],
                    [ 'core/paragraph', [
                        'placeholder' => __('Add some bio text …', 'pedalcms'),
                    ] ],
                ] ],
                [ 'core/column', ['width' => '33.33%'], [
                    ['core/post-featured-image'],
                    ['pdl/contact-info']
                ] ],
            ] ],
        ];
    }

    protected function setup_post_meta() {
        $this->post_meta = [
            'job_title' => [
                'label'             => __('Job Title', 'pedalcms'),
                'description'       => __('The current position this team member holds', 'pedalcms'),
                'type'              => 'string',
                'default'           => '',
                'single'            => true,
                'sanitize_callback' => 'sanitize_text_field',
                'show_in_rest'      => true
            ],
            'office_phone' => [
                'label'             => __('Office Phone', 'pedalcms'),
                'description'       => '',
                'type'              => 'string',
                'default'           => '',
                'single'            => true,
                'sanitize_callback' => 'sanitize_text_field',
                'show_in_rest'      => true
            ],
            'email_address' => [
                'label'             => __('Email Address', 'pedalcms'),
                'description'       => '',
                'type'              => 'string',
                'default'           => '',
                'single'            => true,
                'sanitize_callback' => 'sanitize_email',
                'show_in_rest'      => true
            ],
            'office' => [
                'label'             => __('Office', 'pedalcms'),
                'description'       => '',
                'type'              => 'string',
                'default'           => '',
                'single'            => true,
                'sanitize_callback' => 'sanitize_text_field',
                'show_in_rest'      => true
            ]
        ];
    }

    protected function setup_field_group() {
        $field_group = [
            'key'      => 'group_61140677b6acb',
            'title'    => __('Person Info', 'pedalcms'),
            'location' => [
                [
                    [
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => self::POST_TYPE,
                    ],
                ],
            ],
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'seamless',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'active'                => true,
            'fields'                => [
                [
                    'key'               => 'field_611406a953e0e',
                    'label'             => __('Job Title', 'pedalcms'),
                    'name'              => 'job_title',
                    'type'              => 'text',
                    'instructions'      => '',
                ],
                [
                    'key'               => 'field_611406db53e0f',
                    'label'             => __('Office Phone', 'pedalcms'),
                    'name'              => 'office_phone',
                    'type'              => 'text',
                    'instructions'      => '',
                    'placeholder'       => '(919) 555-1001',
                ],
                [
                    'key'               => 'field_6114072c53e10',
                    'label'             => __('Email Address', 'pedalcms'),
                    'name'              => 'email_address',
                    'type'              => 'email',
                    'instructions'      => '',
                ],
                [
                    'key'               => 'field_6140ba895cb46',
                    'label'             => __('Office Location', 'pedalcms'),
                    'name'              => 'office',
                    'type'              => 'text',
                    'instructions'      => '',
                    'placeholder'       => _x('Main Building, 448C', 'office field placeholder', 'pedalcms'),
                ],
                [
                    'key'           => 'field_631b3c6e7dc61',
                    'label'         => __('Category','pedalcms'),
                    'name'          => 'person_category',
                    'type'          => 'taxonomy',
                    'instructions'  => '',
                    'required'      => 0,
                    'taxonomy'      => PersonCategory::TAXONOMY,
                    'field_type'    => 'radio',
                    'allow_null'    => 0,
                    'add_term'      => 0,
                    'save_terms'    => 1,
                    'load_terms'    => 1,
                    'return_format' => 'object',
                ],
                [
                    'key'           => 'field_611279af182d2',
                    'label'         => __('College','pedalcms'),
                    'name'          => 'college',
                    'type'          => 'taxonomy',
                    'instructions'  => '',
                    'required'      => 0,
                    'taxonomy'      => College::TAXONOMY,
                    'field_type'    => 'select',
                    'allow_null'    => 0,
                    'add_term'      => 0,
                    'save_terms'    => 1,
                    'load_terms'    => 1,
                    'return_format' => 'object',
                    'multiple'      => 0,
                ],
                [
                    'key'           => 'field_630fb69367bc5',
                    'label'         => __('Department','pedalcms'),
                    'name'          => 'department',
                    'type'          => 'select',
                    'instructions'  => '',
                    'placeholder'   => __('Select department', 'pedalcms'),
                    'default_value' => 0,
                    'required'      => 0,
                    'taxonomy'      => Department::TAXONOMY,
                    'field_type'    => 'select',
                    'allow_null'    => 0,
                    'add_term'      => 0,
                    'save_terms'    => 0,
                    'load_terms'    => 0,
                    'return_format' => 'id',
                    'multiple'      => 0,
                    'ui'            => 0,
                    'ajax'          => 0,
                    'disable'       => 1,
                    'choices'       => [
                        0 => __('(Select college first)', 'pedalcms')
                    ]
                ],
                [
                    'key'               => 'field_615f36c2ba5cf',
                    'label'             => __('Courses Taught', 'pedalcms'),
                    'name'              => 'related_person_courses',
                    'type'              => 'relationship',
                    'instructions'      => '',
                    'post_type'         => [0 => Course::POST_TYPE],
                    'taxonomy'          => '',
                    'filters'           => [
                        0 => 'search',
                        1 => 'taxonomy',
                    ],
                    'return_format' => 'id',
                ],
            ],
        ];

        $this->field_groups[] = $field_group;
    }

    public function setup_hooks(): void {
        add_action('pre_get_posts', [static::class, 'update_sort_order']);
        add_action('wp_after_insert_post', [static::class, 'save_terms'], 10, 2);

        return;
    }

    /**
     * Changes the sort order for Person.
     *
     * Called on filter: pre_get_posts
     *
     * @param WP_Query $query The current WP_Query
     * @return void
     */
    public static function update_sort_order(\WP_Query $query): void {
        $update_order =
            $query->is_main_query() &&
            !is_admin() &&
            !$query->get('orderby') &&
            $query->is_post_type_archive(self::POST_TYPE);

        if ($update_order) {
            $query->set('order', 'ASC');
            $query->set('orderby', 'title');
        }

        return;
    }

    public static function save_terms($post_id, $post) {
        if ($post->post_type === self::POST_TYPE) {
            Department::save_terms($post);
        }
    }

    /**
     * Takes a list of People and returns them indexed by category.
     *
     * @param array $people A list of People of the type WP_Post.
     * @return array The category indexed list of people.
     */
    public static function group_by_category(array $people): array {
        return self::group_by_tax($people, PersonCategory::TAXONOMY, 'people');
    }

    /**
     * Determines whether the block editor should be enabled for Person.
     *
     * @return boolean
     */
    public static function is_block_editor_enabled(): bool {
        return (bool) Plugin::get_option('enable_block_editor_personnel');
    }

    /**
     * Retrieves the appropriate ACF field group based on block editor setting.
     *
     * @return array The ACF Field Group.
     */
    public static function get_field_group(): array {
        $instance = static::get_instance();

        $group = $instance->field_groups[0] ?? [];

        if (!self::is_block_editor_enabled()) {
            return $group;
        }

        // The courses relationship field is the last one.
        $group['fields'] = array_slice($group['fields'], -1);

        return $group;
    }

}
