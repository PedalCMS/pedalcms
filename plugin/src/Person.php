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
     * The proper name.
     *
     * @var string
     */
    public string $name = 'Person';

    /**
     * The plural version of the proper name.
     *
     * @var string
     */
    public string $plural_name = 'Personnel';

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
        'template'            => [
            [ 'core/columns', [], [
                [ 'core/column', ['width' => '66.66%'], [
                    ['nvis/job-title'],
                    [ 'core/paragraph', [
                        'placeholder' => 'Add some bio text …'
                    ] ],
                ] ],
                [ 'core/column', ['width' => '33.33%'], [
                    ['core/post-featured-image'],
                    ['nvis/contact-info']
                ] ],
            ] ],
        ]
    ];

    public static array $post_meta = [
        'job_title' => [
            'label'             => 'Job Title',
            'description'       => 'The current position this team member holds',
            'type'              => 'string',
            'default'           => '',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'show_in_rest'      => true
        ],
        'office_phone' => [
            'label'             => 'Office Phone',
            'description'       => '',
            'type'              => 'string',
            'default'           => '',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'show_in_rest'      => true
        ],
        'email_address' => [
            'label'             => 'Email Address',
            'description'       => '',
            'type'              => 'string',
            'default'           => '',
            'single'            => true,
            'sanitize_callback' => 'sanitize_email',
            'show_in_rest'      => true
        ],
        'office' => [
            'label'             => 'Office',
            'description'       => '',
            'type'              => 'string',
            'default'           => '',
            'single'            => true,
            'sanitize_callback' => 'sanitize_text_field',
            'show_in_rest'      => true
        ]
    ];


    public static $field_groups = [
        [
            'key'      => 'group_61140677b6acb',
            'title'    => 'Contact Info',
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
                    'label'             => 'Job Title',
                    'name'              => 'job_title',
                    'type'              => 'text',
                    'instructions'      => '',
                ],
                [
                    'key'               => 'field_611406db53e0f',
                    'label'             => 'Office Phone',
                    'name'              => 'office_phone',
                    'type'              => 'text',
                    'instructions'      => '',
                    'placeholder'       => '(919) 555-1001',
                ],
                [
                    'key'               => 'field_6114072c53e10',
                    'label'             => 'Email Address',
                    'name'              => 'email_address',
                    'type'              => 'email',
                    'instructions'      => '',
                ],
                [
                    'key'               => 'field_6140ba895cb46',
                    'label'             => 'Office',
                    'name'              => 'office',
                    'type'              => 'text',
                    'instructions'      => '',
                    'placeholder'       => 'Main Building, 448C'
                ],
            ],
        ]
    ];

    public function register(): void {
        if (!self::is_block_editor_enabled()) {
            $this->args['show_in_rest'] = false;
        }

        parent::register();
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
        return (bool) get_field('enable_block_editor_personnel', 'option');
    }
}
