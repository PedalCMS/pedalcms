<?php

namespace InvisibleUs\Programs;

/**
 * FAQ custom post type.
 * 
 * @version 0.1.0
 * @package NVISPrograms
 * @since 0.1.0
 */
class FAQ extends CustomPostType {
    /**
     * The post type to register.
     */
    public const POST_TYPE = 'nvis_faq';

    /**
     * The proper name.
     *
     * @var string
     */
    public string $name = 'FAQ';

    /**
     * The plural version of the proper name.
     *
     * @var string
     */
    public string $plural_name = 'FAQs';

    /**
     * Whether or not it is safe to lowercase the name.
     *
     * @var boolean
     */
    public bool $lowercase_safe = false;

    /**
     * The Text to
     *
     * @var string
     */
    public static string $enter_title_text = 'Enter the Question';

    /**
     * The args to pass to register_post_type.
     *
     * Gets updated throughout the setup process.
     *
     * @var array
     */
    public array $args = [
        'rewrite'             => ['slug' => 'faq'],
        'has_archive'         => 'faqs',
        'capability_type'     => self::POST_TYPE,
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

    /**
     * Takes a list of FAQs and returns them indexed by category.
     *
     * @param array $faqs A list of FAQs of the type WP_Post.
     * @return array The category indexed list of FAQs.
     */
    public static function group_by_category(array $faqs): array {
        return self::group_by_tax($faqs, FAQCategory::TAXONOMY, 'faqs');
    }
}
