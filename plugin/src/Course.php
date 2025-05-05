<?php

namespace PedalCMS\Core;

/**
 * Course custom post type.
 *
 * @package PedalCMS
 * @subpackage ContentModel
 * @since 0.1.0
 */
class Course extends CustomPostType {
    /**
     * The post type to register.
     */
    public const POST_TYPE = 'pdl_course';

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
        'menu_icon'           => '',
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
        $this->args['labels'] = [
            'name'                     => _x( 'Course Catalog', 'post type general name', 'pedalcms' ),
            'singular_name'            => _x( 'Course', 'post type singular name', 'pedalcms' ),
            'plural_not_collective'    => _x( 'Courses', 'post type plural name not collective', 'pedalcms' ),
            'add_new_item'             => __( 'Add New Course', 'pedalcms' ),
            'edit_item'                => __( 'Edit Course', 'pedalcms' ),
            'new_item'                 => __( 'New Course', 'pedalcms' ),
            'view_item'                => __( 'View Course', 'pedalcms' ),
            'view_items'               => __( 'View Courses', 'pedalcms' ),
            'search_items'             => __( 'Search Courses', 'pedalcms' ),
            'not_found'                => __( 'No courses found.', 'pedalcms' ),
            'not_found_in_trash'       => __( 'No courses found in Trash.', 'pedalcms' ),
            'parent_item_colon'        => __( 'Parent Course:', 'pedalcms'),
            'all_items'                => __( 'All Courses', 'pedalcms' ),
            'archives'                 => __( 'Course Catalog', 'pedalcms' ),
            'attributes'               => __( 'Course Attributes', 'pedalcms' ),
            'insert_into_item'         => __( 'Insert into course', 'pedalcms' ),
            'uploaded_to_this_item'    => __( 'Uploaded to this course', 'pedalcms' ),
            'filter_items_list'        => __( 'Filter courses list', 'pedalcms' ),
            'items_list_navigation'    => __( 'Courses list navigation', 'pedalcms' ),
            'items_list'               => __( 'Courses list', 'pedalcms' ),
            'item_published'           => __( 'Course published.', 'pedalcms' ),
            'item_published_privately' => __( 'Course published privately.', 'pedalcms' ),
            'item_reverted_to_draft'   => __( 'Course reverted to draft.', 'pedalcms' ),
            'item_scheduled'           => __( 'Course scheduled.', 'pedalcms' ),
            'item_updated'             => __( 'Course updated.', 'pedalcms' ),
            'item_link'                => _x( 'Course Link', 'navigation link block title', 'pedalcms' ),
            'item_link_description'    => _x( 'A link to a course.', 'navigation link block description', 'pedalcms' ),
        ];
    }

    protected function setup_field_group() {
        $field_group = [
            'key'      => 'group_612f7f2c97e10',
            'title'    => __('Course Info', 'pedalcms'),
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
                    'label'             => __('Course Description', 'pedalcms'),
                    'name'              => 'short_description',
                    'type'              => 'textarea',
                    'instructions'      => __('The short description of the course. No more than a paragraph.', 'pedalcms'),
                ],
                [
                    'key'               => 'field_61dc6ea8d1509',
                    'label'             => __('Course Code', 'pedalcms'),
                    'name'              => 'course_code',
                    'type'              => 'text',
                    'instructions'      => __('The short identifier for a course. Usually some combination of subject code and a number.', 'pedalcms'),
                    'placeholder'       => 'CS101',
                    'wrapper'           => ['width' => '25'],
                ],
                [
                    'key'               => 'field_615226746dddd',
                    'label'             => __('Credit Hours', 'pedalcms'),
                    'name'              => 'credits',
                    'type'              => 'number',
                    'instructions'      => __('Number of credit hours earned for this course. Sometimes also referred to as units.', 'pedalcms'),
                    'placeholder'       => 1,
                    'wrapper'           => ['width' => '25'],
                ],
                [
                    'key'               => 'field_61252546d4a0d',
                    'label'             => __('Course Registration Key', 'pedalcms'),
                    'name'              => 'course_registration_key',
                    'type'              => 'text',
                    'instructions'      => __('They key, or ID, that you can use to search course registration systems for this course via URL parameter.', 'pedalcms'),
                    'wrapper'           => ['width' => '50'],
                    'placeholder'       => ''
                ],
                [
                    'key'               => 'field_612e96a887a06',
                    'label'             => __('Registration Search URL', 'pedalcms'),
                    'name'              => 'url_reg_search',
                    'type'              => 'url',
                    'instructions'      => __('Enter a URL for the "Search Sections" link. Overrides global setting.', 'pedalcms'),
                    'placeholder'       => '',
                ],
                [
                    'key'               => 'field_615f36b994871',
                    'label'             => __('Instructors', 'pedalcms'),
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

    public function setup_hooks(): void {
        add_action('pre_get_posts', [static::class, 'update_sort_order']);
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

    /**
     * Prefixes the course title with the course code.
     *
     * @since 0.1.0
     *
     * @param mixed $post Either the ID of a post or a WP_Post object. Deafults to the current course.
     * @return string The full title.
     */
    public static function get_full_title($post = null): string {
        $post = get_post($post);
        $title = '';

        if ($post->course_code) {
            $title .= sprintf(
                '<span class="course-code">%s</span> <span class="separator">&ndash;</span>',
                esc_html($post->course_code)
            );
        }

        $title .= sprintf(
            '<span class="course-name">%s</span>',
            // TODO: should this be a call to get_the_title?
            esc_html($post->post_title)
        );

        // TODO: Filter this or consider .
        return $title;
    }

    /**
     * Returns the full URL for a given course action.
     *
     * Will check for a local course override before attempting to build it from
     * the plugin wide pattern setting.
     *
     * @since 0.1.0
     *
     * @param string $action The name of the action.
     * @param mixed $program The ID of the course or a WP_Post object. Defaults to the current course.
     * @return string The URL of the course action.
     */
    public static function get_action_link(string $action, $course = null): string {
        $course = get_post($course);

        $url = get_field('url_' . $action, $course);

        if ($url) {
            return $url;
        }

        $url = \PedalCMS\Core\Plugin::get_option('course_url_' . $action);

        if ($url) {
            $url = str_replace(
                [
                    '{$course_cat_key}',
                    '{$course_reg_key}'
                ],
                [
                    get_field('course_catalog_key', $course),
                    get_field('course_registration_key', $course)
                ],
                $url
            );

            return $url;
        }

        return '';
    }
}
