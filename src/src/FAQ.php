<?php

namespace InvisibleUs\Programs;

class FAQ extends CustomPostType {
    /**
     * The post type to register.
     */
    public const post_type = 'nvis_faq';

    /**
     * The proper name.
     *
     * @var string
     */
    public $name = 'FAQ';

    /**
     * The plural version of the proper name.
     *
     * @var string
     */
    public $plural_name = 'FAQs';

    /**
     * Whether or not it is safe to lowercase the name.
     *
     * @var boolean
     */
    public $lowercase_safe = false;

    /**
     * The args to pass to register_post_type.
     *
     * Gets updated throughout the setup process.
     *
     * @var array
     */
    public $args = [
        'rewrite'             => ['slug' => 'faq'],
        'has_archive'         => 'faqs',
        'capability_type'     => self::post_type,
        'menu_icon'           => 'dashicons-editor-help',
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
