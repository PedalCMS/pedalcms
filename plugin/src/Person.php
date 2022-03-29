<?php

namespace InvisibleUs\Programs;

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
    public const POST_TYPE = 'nvis_person';

    /**
     * The replacement text for enter_title_here filter.
     *
     * @var string
     */
    public static string $enter_title_text = 'Enter the Full Name';

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
        $this->args['labels'] = [
            'name'                     => _x( 'Personnel', 'post type general name', 'nvis-program-pages' ),
            'singular_name'            => _x( 'Person', 'post type singular name', 'nvis-program-pages' ),
            'add_new_item'             => __( 'Add New Person', 'nvis-program-pages' ),
            'edit_item'                => __( 'Edit Person', 'nvis-program-pages' ),
            'new_item'                 => __( 'New Person', 'nvis-program-pages' ),
            'view_item'                => __( 'View Person', 'nvis-program-pages' ),
            'view_items'               => __( 'View Personnel', 'nvis-program-pages' ),
            'search_items'             => __( 'Search Personnel', 'nvis-program-pages' ),
            'not_found'                => __( 'No personnel found.', 'nvis-program-pages' ),
            'not_found_in_trash'       => __( 'No personnel found in Trash.', 'nvis-program-pages' ),
            'parent_item_colon'        => __( 'Parent Person:', 'nvis-program-pages' ),
            'all_items'                => __( 'All Personnel', 'nvis-program-pages' ),
            'archives'                 => __( 'Directory', 'nvis-program-pages' ),
            'attributes'               => __( 'Person Attributes', 'nvis-program-pages' ),
            'insert_into_item'         => __( 'Insert into person post', 'nvis-program-pages' ),
            'uploaded_to_this_item'    => __( 'Uploaded to this person', 'nvis-program-pages' ),
            'filter_items_list'        => __( 'Filter personnel list', 'nvis-program-pages' ),
            'items_list_navigation'    => __( 'Personnel list navigation', 'nvis-program-pages' ),
            'items_list'               => __( 'Personnel list', 'nvis-program-pages' ),
            'item_published'           => __( 'Person published.', 'nvis-program-pages' ),
            'item_published_privately' => __( 'Person published privately.', 'nvis-program-pages' ),
            'item_reverted_to_draft'   => __( 'Person reverted to draft.', 'nvis-program-pages' ),
            'item_scheduled'           => __( 'Person scheduled.', 'nvis-program-pages' ),
            'item_updated'             => __( 'Person updated.', 'nvis-program-pages' ),
            'item_link'                => _x( 'Person Link', 'navigation link block title', 'nvis-program-pages' ),
            'item_link_description'    => _x( 'A link to a person.', 'navigation link block description', 'nvis-program-pages' ),
        ];
    }

    protected function setup_template() {
        $this->args['template'] = [
            [ 'core/columns', [], [
                [ 'core/column', ['width' => '66.66%'], [
                    ['nvis/job-title'],
                    [ 'core/paragraph', [
                        'placeholder' => __('Add some bio text …', 'nvis-program-pages'),
                    ] ],
                ] ],
                [ 'core/column', ['width' => '33.33%'], [
                    ['core/post-featured-image'],
                    ['nvis/contact-info']
                ] ],
            ] ],
        ];
    }

    protected function setup_post_meta() {
        $this->post_meta = [
            'job_title' => [
                'label'             => __('Job Title', 'nvis-program-pages'),
                'description'       => __('The current position this team member holds', 'nvis-program-pages'),
                'type'              => 'string',
                'default'           => '',
                'single'            => true,
                'sanitize_callback' => 'sanitize_text_field',
                'show_in_rest'      => true
            ],
            'office_phone' => [
                'label'             => __('Office Phone', 'nvis-program-pages'),
                'description'       => '',
                'type'              => 'string',
                'default'           => '',
                'single'            => true,
                'sanitize_callback' => 'sanitize_text_field',
                'show_in_rest'      => true
            ],
            'email_address' => [
                'label'             => __('Email Address', 'nvis-program-pages'),
                'description'       => '',
                'type'              => 'string',
                'default'           => '',
                'single'            => true,
                'sanitize_callback' => 'sanitize_email',
                'show_in_rest'      => true
            ],
            'office' => [
                'label'             => __('Office', 'nvis-program-pages'),
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
            'title'    => __('Contact Info', 'nvis-program-pages'),
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
            'position'              => 'acf_after_title',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'active'                => true,
            'fields'                => [
                [
                    'key'               => 'field_611406a953e0e',
                    'label'             => __('Job Title', 'nvis-program-pages'),
                    'name'              => 'job_title',
                    'type'              => 'text',
                    'instructions'      => '',
                ],
                [
                    'key'               => 'field_611406db53e0f',
                    'label'             => __('Office Phone', 'nvis-program-pages'),
                    'name'              => 'office_phone',
                    'type'              => 'text',
                    'instructions'      => '',
                    'placeholder'       => '(919) 555-1001',
                ],
                [
                    'key'               => 'field_6114072c53e10',
                    'label'             => __('Email Address', 'nvis-program-pages'),
                    'name'              => 'email_address',
                    'type'              => 'email',
                    'instructions'      => '',
                ],
                [
                    'key'               => 'field_6140ba895cb46',
                    'label'             => __('Office', 'nvis-program-pages'),
                    'name'              => 'office',
                    'type'              => 'text',
                    'instructions'      => '',
                    'placeholder'       => _x('Main Building, 448C', 'office field placeholder', 'nvis-program-pages'),
                ],
                [
                    'key'               => 'field_615f36c2ba5cf',
                    'label'             => __('Courses Taught', 'nvis-program-pages'),
                    'name'              => 'related_person_persons',
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
        if (is_post_type_archive(self::POST_TYPE)) {
            $query->set('order', 'ASC');
            $query->set('orderby', 'title');
        }

        return;
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
