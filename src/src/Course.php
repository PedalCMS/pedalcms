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
}
