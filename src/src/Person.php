<?php

namespace InvisibleUs\Programs;

class Person extends CustomPostType {
    /**
     * The post type to register.
     */
    public const post_type = 'nvis_person';

    /**
     * The proper name.
     *
     * @var string
     */
    public $name = 'Faculty & Staff';

    /**
     * The plural version of the proper name.
     *
     * @var string
     */
    public $plural_name = 'Faculty & Staff';

    /**
     * The args to pass to register_post_type.
     *
     * Gets updated throughout the setup process.
     *
     * @var array
     */
    public $args = [
        'rewrite'             => ['slug' => 'person'],
        'has_archive'         => 'people',
        'capability_type'     => self::post_type,
        'menu_icon'           => 'dashicons-businesswoman',
        'menu_position'       => 5,
        'description'         => '',
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'supports'            => ['title', 'editor', 'thumbnail'],
    ];
}
