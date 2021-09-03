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
     * The Text to
     *
     * @var string
     */
    public static $enter_title_text = 'Enter the Question';

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

    /**
     * Takes a list of FAQs and returns them indexed by category.
     *
     * @param array $faqs A list of FAQs of the type WP_Post.
     * @return array The category indexed list of FAQs.
     */
    public static function group_by_category(array $faqs): array {
        $cats = [];

        foreach ($faqs as $faq) {
            $terms = get_the_terms($faq, FAQCategory::taxonomy);

            if (is_array($terms)) {
                $cat = array_shift($terms);

                if (!isset($cats[$cat->slug])) {
                    $cat->faqs = [];
                    $cats[ $cat->slug ] = $cat;
                }

                $cats[$cat->slug]->faqs[] = $faq;
            }
        }

        return $cats;
    }
}
