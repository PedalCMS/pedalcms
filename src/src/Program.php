<?php

namespace InvisibleUs\Programs;

class Program extends CustomPostType {
    /**
     * The post type to register.
     */
    public const post_type = 'nvis_program';

    /**
     * The proper name.
     *
     * @var string
     */
    public $name = 'Program';

    /**
     * The plural version of the proper name.
     *
     * @var string
     */
    public $plural_name = 'Programs';

    /**
     * The args to pass to register_post_type.
     *
     * Gets updated throughout the setup process.
     *
     * @var array
     */
    public $args = [
        'has_archive'         => 'programs',
        'rewrite'             => ['slug' => 'program', 'with_front' => true],
        'capability_type'     => self::post_type,
        'menu_icon'           => 'dashicons-welcome-learn-more',
        'menu_position'       => 5,
        'description'         => '',
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'supports'            => ['title', 'thumbnail'],
    ];

    /**
     * A list of field group arrays to pass to acf_add_local_field_group.
     *
     * @var array
     */
    public static $field_groups = [
        [
            'key'         => 'group_61118a19b2e4c',
            'title'       => 'Program Info',
            'location'    => [
                [
                    [
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'nvis_program',
                    ],
                ],
            ],
            'menu_order'            => 0,
            'position'              => 'acf_after_title',
            'style'                 => 'seamless',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen'        => '',
            'active'                => true,
            'fields'                => [
                [
                    'key'       => 'field_6112749bd4b71',
                    'label'     => 'Main',
                    'type'      => 'tab',
                    'placement' => 'top',
                    'endpoint'  => 0,
                ],
                [
                    'key'          => 'field_6112773d640f4',
                    'label'        => 'Program GUID',
                    'name'         => 'program_guid',
                    'type'         => 'text',
                    'instructions' => 'The globally unique identifier for the program. Typically, used campus-wide across systems.',
                ],
                [
                    'key'           => 'field_611279af182d2',
                    'label'         => 'College',
                    'name'          => 'college',
                    'type'          => 'taxonomy',
                    'instructions'  => '',
                    'required'      => 1,
                    'taxonomy'      => 'nvis_program_college',
                    'field_type'    => 'select',
                    'allow_null'    => 0,
                    'add_term'      => 0,
                    'save_terms'    => 1,
                    'load_terms'    => 1,
                    'return_format' => 'object',
                    'multiple'      => 0,
                ],
                [
                    'key'           => 'field_61127c46a8faf',
                    'label'         => 'Program Type',
                    'name'          => 'program_type',
                    'type'          => 'taxonomy',
                    'instructions'  => '',
                    'required'      => 1,
                    'taxonomy'      => 'nvis_program_type',
                    'field_type'    => 'radio',
                    'allow_null'    => 0,
                    'add_term'      => 0,
                    'save_terms'    => 1,
                    'load_terms'    => 1,
                    'return_format' => 'object',
                    'multiple'      => 0,
                ],
                [
                    'key'           => 'field_61127a1f182d4',
                    'label'         => 'Delivery Format',
                    'name'          => 'delivery_format',
                    'type'          => 'taxonomy',
                    'instructions'  => '',
                    'taxonomy'      => 'nvis_program_format',
                    'field_type'    => 'radio',
                    'allow_null'    => 0,
                    'add_term'      => 0,
                    'save_terms'    => 1,
                    'load_terms'    => 1,
                    'return_format' => 'object',
                    'multiple'      => 0,
                ],
                [
                    'key'           => 'field_61128ea8b1920',
                    'label'         => 'Prerequisites',
                    'name'          => 'prerequisites',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'message'       => '',
                    'default_value' => true,
                    'ui'            => 1,
                    'ui_on_text'    => '',
                    'ui_off_text'   => '',
                ],
                [
                    'key'           => 'field_6112738ed4b70',
                    'label'         => 'Overview Content',
                    'name'          => 'overview_content',
                    'type'          => 'wysiwyg',
                    'instructions'  => '',
                    'default_value' => '',
                    'tabs'          => 'all',
                    'toolbar'       => 'full',
                    'media_upload'  => 1,
                    'delay'         => 0,
                ],
                [
                    'key'          => 'field_61127d078fbcb',
                    'label'        => 'Request Info URL',
                    'name'         => 'url_request_info',
                    'type'         => 'url',
                    'instructions' => 'Overrides the global pattern for Request Info URLs.',
                    'placeholder'  => '',
                ],
                [
                    'key'          => 'field_61127d728fbcc',
                    'label'        => 'Apply Now URL',
                    'name'         => 'url_apply_now',
                    'type'         => 'url',
                    'instructions' => 'Overrides the global pattern for Apply Now URLs.',
                    'placeholder'  => '',
                ],
                [
                    'key'          => 'field_612405570ceb7',
                    'label'        => 'Application Deadlines',
                    'name'         => 'application_deadlines',
                    'type'         => 'repeater',
                    'instructions' => 'Leave blank to inherit.',
                    'collapsed'    => 'field_61156b777d403',
                    'layout'       => 'block',
                    'button_label' => 'Add Deadline',
                    'sub_fields'   => [
                        [
                            'key'          => 'field_61156b777d403',
                            'label'        => 'Deadline Label',
                            'name'         => 'deadline_label',
                            'type'         => 'text',
                            'instructions' => '',
                            'required'     => 1,
                            'placeholder'  => 'Fall, Spring, etc.',
                            'maxlength'    => '',
                        ],
                        [
                            'key'          => 'field_61156bbe7d404',
                            'label'        => 'Deadline Info',
                            'name'         => 'deadline_info',
                            'type'         => 'text',
                            'instructions' => '',
                            'placeholder'  => 'e.g. June 24th',
                            'maxlength'    => '',
                        ],
                    ],
                ],
                [
                    'key'          => 'field_61127d948fbcd',
                    'label'        => 'Contact Us URL',
                    'name'         => 'url_contact_us',
                    'type'         => 'url',
                    'instructions' => 'Overrides the global pattern for Contact Us URLs.',
                    'placeholder'  => '',
                ],
                [
                    'key'          => 'field_611276e3640f3',
                    'label'        => 'Program Contacts',
                    'name'         => 'related_contacts',
                    'type'         => 'relationship',
                    'instructions' => '',
                    'post_type'    => [
                        0 => 'nvis_person',
                    ],
                    'taxonomy' => '',
                    'filters'  => [
                        0 => 'search',
                    ],
                    'elements' => [
                        0 => 'featured_image',
                    ],
                    'min'           => '',
                    'max'           => '',
                    'return_format' => 'object',
                ]
            ]
        ]
    ];

    public function setup_hooks(): void {
        add_action('pre_get_posts', [static::class, 'update_sort_order']);
    }

    public static function update_sort_order(\WP_Query $query): void {
        if (is_post_type_archive(self::post_type)) {
            $query->set('order', 'ASC');
            $query->set('orderby', 'title');
        }

        return;
    }

    public static function get_related_posts($program = null, array $not_in = []): array {
        $program = get_post($program);

        $tag = get_field('news_tag', $program);
        $num_posts = get_field('news_num_posts', $program);

        if (!$tag) {
            return [];
        }

        $args = [
            'tag_id'              => $tag,
            'ignore_sticky_posts' => true,
            'posts_per_page'      => $num_posts
        ];

        if (!empty($not_in)) {
            $args['post__not_in'] = $not_in;
        }

        return get_posts($args);
    }

    public static function get_application_deadlines($program = null): array {
        $program = get_post($program);

        // First, check if the program has specific deadlines.
        $deadlines = get_field('application_deadlines', $program);

        if (!empty($deadlines)) {
            return $deadlines;
        }

        // Then, check if either the college or the program type has overriden.
        $terms = ['college','program_type'];

        foreach ($terms as $name) {
            $term = get_field($name, $program);

            if (!empty($term)) {
                $deadlines = get_field('application_deadlines', $term);

                if (!empty($deadlines)) {
                    return $deadlines;
                }
            }
        }

        // If all else fails, just return the global setting.
        return get_field('nvis_application_deadlines', 'option');
    }
}
