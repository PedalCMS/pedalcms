<?php

namespace InvisibleUs\Programs;

class Course extends CustomPostType {
    /**
     * The post type to register.
     */
    public const post_type = 'nvis_course';

    /**
     * The proper name.
     *
     * @var string
     */
    public $name = 'Course';

    /**
     * The plural version of the proper name.
     *
     * @var string
     */
    public $plural_name = 'Courses';

    /**
     * The args to pass to register_post_type.
     *
     * Gets updated throughout the setup process.
     *
     * @var array
     */
    public $args = [
        'rewrite'             => ['slug' => 'course'],
        'has_archive'         => 'courses',
        'capability_type'     => Program::post_type,
        'menu_icon'           => 'dashicons-book-alt',
        'menu_position'       => 5,
        'description'         => '',
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'supports'            => ['title', 'editor'],
    ];

    public static $field_groups = [
        [
            'key'    => 'group_612f7f2c97e10',
            'title'  => 'Course Info',
            'fields' => [
                [
                    'key'               => 'field_61252469d4a0c',
                    'label'             => 'Course Catalog Key',
                    'name'              => 'course_catalog_key',
                    'type'              => 'text',
                    'instructions'      => 'They key, or ID, that you can use to search course catalogs for this course via URL parameter.',
                    'wrapper'           => ['width' => '50'],
                    'placeholder'       => '',
                    'maxlength'         => 16,
                ],
                [
                    'key'               => 'field_61252546d4a0d',
                    'label'             => 'Course Registration Key',
                    'name'              => 'course_registration_key',
                    'type'              => 'text',
                    'instructions'      => 'They key, or ID, that you can use to search course registrations for this course via URL parameter.',
                    'wrapper'           => ['width' => '50'],
                    'default_value'     => '',
                    'placeholder'       => '61252586f020c'
                ],
                [
                    'key'               => 'field_6125264d27bb4',
                    'label'             => 'Related Programs',
                    'name'              => 'related_programs',
                    'type'              => 'relationship',
                    'instructions'      => '',
                    'post_type'         => [0 => 'nvis_program'],
                    'taxonomy'          => '',
                    'filters'           => [
                        0 => 'search',
                        1 => 'taxonomy',
                    ],
                    'return_format' => 'id',
                ],
                [
                    'key'               => 'field_612e962087a05',
                    'label'             => 'More Info URL',
                    'name'              => 'url_more_info',
                    'type'              => 'url',
                    'instructions'      => 'Enter a URL for the "More Info" link. Overrides global setting.',
                    'placeholder'       => '',
                ],
                [
                    'key'               => 'field_612e96a887a06',
                    'label'             => 'Registration Search URL',
                    'name'              => 'url_reg_search',
                    'type'              => 'url',
                    'instructions'      => 'Enter a URL for the "More Info" link. Overrides global setting.',
                    'placeholder'       => '',
                ],
            ],
            'location' => [
                [
                    [
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'nvis_course',
                    ],
                ],
            ],
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'field',
            'active'                => true,
            'description'           => '',
        ]
    ];
}
