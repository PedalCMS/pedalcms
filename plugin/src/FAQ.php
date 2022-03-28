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

    protected function setup_labels(): void {
        self::$enter_title_text = __('Enter the Question', 'nvis-program-pages');

        $this->args['labels'] = [
            'name'                     => _x( 'FAQs', 'post type general name', 'nvis-program-pages' ),
            'singular_name'            => _x( 'FAQ', 'post type singular name', 'nvis-program-pages' ),
            'add_new_item'             => __( 'Add New FAQ', 'nvis-program-pages' ),
            'edit_item'                => __( 'Edit FAQ', 'nvis-program-pages' ),
            'new_item'                 => __( 'New FAQ', 'nvis-program-pages' ),
            'view_item'                => __( 'View FAQ', 'nvis-program-pages' ),
            'view_items'               => __( 'View FAQs', 'nvis-program-pages' ),
            'search_items'             => __( 'Search FAQs', 'nvis-program-pages' ),
            'not_found'                => __( 'No FAQs found.', 'nvis-program-pages' ),
            'not_found_in_trash'       => __( 'No FAQs found in Trash.', 'nvis-program-pages' ),
            'parent_item_colon'        => __( 'Parent FAQ:', 'nvis-program-pages' ),
            'all_items'                => __( 'All FAQs', 'nvis-program-pages' ),
            'archives'                 => __( 'FAQ Archives', 'nvis-program-pages' ),
            'attributes'               => __( 'FAQ Attributes', 'nvis-program-pages' ),
            'insert_into_item'         => __( 'Insert into FAQ', 'nvis-program-pages' ),
            'uploaded_to_this_item'    => __( 'Uploaded to this FAQ', 'nvis-program-pages' ),
            'filter_items_list'        => __( 'Filter FAQs list', 'nvis-program-pages' ),
            'items_list_navigation'    => __( 'FAQs list navigation', 'nvis-program-pages' ),
            'items_list'               => __( 'FAQs list', 'nvis-program-pages' ),
            'item_published'           => __( 'FAQ published.', 'nvis-program-pages' ),
            'item_published_privately' => __( 'FAQ published privately.', 'nvis-program-pages' ),
            'item_reverted_to_draft'   => __( 'FAQ reverted to draft.', 'nvis-program-pages' ),
            'item_scheduled'           => __( 'FAQ scheduled.', 'nvis-program-pages' ),
            'item_updated'             => __( 'FAQ updated.', 'nvis-program-pages' ),
            'item_link'                => _x( 'FAQ Link', 'navigation link block title', 'nvis-program-pages' ),
            'item_link_description'    => _x( 'A link to an FAQ.', 'navigation link block description', 'nvis-program-pages' ),
        ];
    }

    /**
     * Takes a list of FAQs and returns them indexed by category.
     *
     * @param array $faqs A list of FAQs of the type WP_Post.
     * @return array The category indexed list of FAQs.
     */
    public static function group_by_category(array $faqs): array {
        return self::group_by_tax($faqs, FAQCategory::TAXONOMY, 'faqs');
    }

    /**
     * Normalizes a list of FAQs of mixed type.
     *
     * @param array $faqs A list of FAQs of mixed type WP_Post.
     * @param bool $group_by_cat Group by FAQCategory?
     * @return array The list of FAQs, either grouped by category or not.
     */
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
