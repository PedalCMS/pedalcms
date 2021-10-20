<?php

namespace InvisibleUs\Programs;

/**
 * FAQ custom post type.
 *
 * @package NVISPrograms
 * @subpackage ContentModel
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

    public static function normalize_faq_types(array $faqs, bool $group_by_cat = false): array {
        $new_list = [];

        foreach ($faqs as $faq) {
            if ($faq['faq_type'] === 'global') {
                $post = $faq['faq_post'];
                $cat = get_the_terms($post, FAQCategory::TAXONOMY);

                if (is_array($cat)) {
                    $cat = $cat[0];
                } else {
                    $cat = null;
                }

                $faq = [
                    'question'     => $post->post_title,
                    'answer'       => apply_filters('the_content', $post->post_content),
                    'faq_category' => $cat
                ];
            } else {
                unset($faq['faq_post']);
            }

            unset($faq['faq_type']);
            $new_list[] = $faq;
        }

        if ($group_by_cat) {
            $groups = [];
            $uncat_term = (object) [
                'slug' => 'uncategorized',
                'name' => 'Uncategorized',
                'faqs' => []
            ];

            foreach ($new_list as $faq) {
                $term = $faq['faq_category'];
                unset($faq['faq_category']);

                if (!$term) {
                    $term = $uncat_term;
                }

                if (!isset($groups[$term->slug])) {
                    $term->faqs = [];
                    $groups[ $term->slug ] = $term;
                }
                $groups[$term->slug]->faqs[] = $faq;
            }

            $new_list = $groups;
        }

        return $new_list;
    }
}
