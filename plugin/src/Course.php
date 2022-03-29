<?php

namespace InvisibleUs\Programs;

/**
 * Course custom post type.
 *
 * @package NVISPrograms
 * @subpackage ContentModel
 * @since 0.1.0
 */
class Course extends CustomPostType {
    /**
     * The post type to register.
     */
    public const POST_TYPE = 'nvis_course';

    /**
     * The args to pass to register_post_type.
     *
     * Gets updated throughout the setup process.
     *
     * @var array
     */
    public array $args = [
        'rewrite'             => ['slug' => 'course'],
        'has_archive'         => 'courses',
        'capability_type'     => self::POST_TYPE,
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

    protected function setup_labels(): void {
        $this->document_title_label = __('Course Catalog','nvis-program-pages');
        
        $this->args['labels'] = [
            'name'                     => _x( 'Courses', 'post type general name', 'nvis-program-pages' ),
            'singular_name'            => _x( 'Course', 'post type singular name', 'nvis-program-pages' ),
            'add_new_item'             => __( 'Add New Course', 'nvis-program-pages' ),
            'edit_item'                => __( 'Edit Course', 'nvis-program-pages' ),
            'new_item'                 => __( 'New Course', 'nvis-program-pages' ),
            'view_item'                => __( 'View Course', 'nvis-program-pages' ),
            'view_items'               => __( 'View Courses', 'nvis-program-pages' ),
            'search_items'             => __( 'Search Courses', 'nvis-program-pages' ),
            'not_found'                => __( 'No courses found.', 'nvis-program-pages' ),
            'not_found_in_trash'       => __( 'No courses found in Trash.', 'nvis-program-pages' ),
            'parent_item_colon'        => __( 'Parent Course:', 'nvis-program-pages'),
            'all_items'                => __( 'All Courses', 'nvis-program-pages' ),
            'archives'                 => __( 'Course Archives', 'nvis-program-pages' ),
            'attributes'               => __( 'Course Attributes', 'nvis-program-pages' ),
            'insert_into_item'         => __( 'Insert into course', 'nvis-program-pages' ),
            'uploaded_to_this_item'    => __( 'Uploaded to this course', 'nvis-program-pages' ),
            'filter_items_list'        => __( 'Filter courses list', 'nvis-program-pages' ),
            'items_list_navigation'    => __( 'Courses list navigation', 'nvis-program-pages' ),
            'items_list'               => __( 'Courses list', 'nvis-program-pages' ),
            'item_published'           => __( 'Course published.', 'nvis-program-pages' ),
            'item_published_privately' => __( 'Course published privately.', 'nvis-program-pages' ),
            'item_reverted_to_draft'   => __( 'Course reverted to draft.', 'nvis-program-pages' ),
            'item_scheduled'           => __( 'Course scheduled.', 'nvis-program-pages' ),
            'item_updated'             => __( 'Course updated.', 'nvis-program-pages' ),
            'item_link'                => _x( 'Course Link', 'navigation link block title', 'nvis-program-pages' ),
            'item_link_description'    => _x( 'A link to a course.', 'navigation link block description', 'nvis-program-pages' ),
        ];
    }

    protected function setup_field_group() {
        $field_group = [
            'key'      => 'group_612f7f2c97e10',
            'title'    => __('Course Info', 'nvis-program-pages'),
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
            'style'                 => 'seamless',
            'label_placement'       => 'top',
            'instruction_placement' => 'field',
            'active'                => true,
            'description'           => '',
            'fields'                => [
                [
                    'key'               => 'field_61dc7bfe9a8f8',
                    'label'             => __('Course Description', 'nvis-program-pages'),
                    'name'              => 'short_description',
                    'type'              => 'textarea',
                    'instructions'      => __('The short description of the course. No more than a paragraph.', 'nvis-program-pages'),
                ],
                [
                    'key'               => 'field_61dc6ea8d1509',
                    'label'             => __('Course Code', 'nvis-program-pages'),
                    'name'              => 'course_code',
                    'type'              => 'text',
                    'instructions'      => __('The short identifier for a course. Usually some combination of subject code and a number.', 'nvis-program-pages'),
                    'placeholder'       => 'CS101',
                    'wrapper'           => ['width' => '25'],
                ],
                [
                    'key'               => 'field_615226746dddd',
                    'label'             => __('Credit Hours', 'nvis-program-pages'),
                    'name'              => 'credits',
                    'type'              => 'number',
                    'instructions'      => __('Number of credit hours earned for this course. Sometimes also referred to as units.', 'nvis-program-pages'),
                    'placeholder'       => 1,
                    'wrapper'           => ['width' => '25'],
                ],
                [
                    'key'               => 'field_61252546d4a0d',
                    'label'             => __('Course Registration Key', 'nvis-program-pages'),
                    'name'              => 'course_registration_key',
                    'type'              => 'text',
                    'instructions'      => __('They key, or ID, that you can use to search course registration systems for this course via URL parameter.', 'nvis-program-pages'),
                    'wrapper'           => ['width' => '50'],
                    'placeholder'       => ''
                ],
                [
                    'key'               => 'field_612e96a887a06',
                    'label'             => __('Registration Search URL', 'nvis-program-pages'),
                    'name'              => 'url_reg_search',
                    'type'              => 'url',
                    'instructions'      => __('Enter a URL for the "Search Sections" link. Overrides global setting.', 'nvis-program-pages'),
                    'placeholder'       => '',
                ],
                [
                    'key'               => 'field_615f36b994871',
                    'label'             => __('Instructors', 'nvis-program-pages'),
                    'name'              => 'related_course_personnel',
                    'type'              => 'relationship',
                    'instructions'      => '',
                    'post_type'         => [0 => Person::POST_TYPE],
                    'taxonomy'          => '',
                    'filters'           => [
                        0 => 'search',
                        1 => 'taxonomy',
                    ],
                    'elements' => [
                        0 => 'featured_image',
                    ],
                    'return_format' => 'object',
                ],
            ],
        ];

        $this->field_groups[] = $field_group;
    }
}
