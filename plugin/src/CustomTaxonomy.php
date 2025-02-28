<?php

namespace PedalCMS\Core;

/**
 * Base class for common custom taxonomy tasks in WordPress.
 *
 * @version 0.1.0
 * @package NVISPrograms
 * @subpackage StandardLib
 * @since 0.1.0
 */
abstract class CustomTaxonomy extends CustomContentObject {
    /**
     * The taxonomy identifier, slug style, to supply to WordPress.
     */
    public const TAXONOMY = '';

    /**
     * The post types to associate with this taxonomy.
     *
     * @var array
     */
    public $object_types = null;

    public array $args = [
        'description'           => '',
        'hierarchical'          => false,
        'labels'                => [],
        'meta_box_cb'           => null,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_nav_menus'     => true,
        'show_admin_column'     => true,
        'show_tag_cloud'        => true,
        'show_in_quick_edit'    => true,
        'query_var'             => true,
        'rewrite'               => true,
        'sort'                  => false
    ];

    /**
     * Constructor.
     */
    protected function __construct() {
        $this->system_name = static::TAXONOMY;
        parent::__construct();
        $this->init();
        $this->init = true;
    }

    public function register(): void {
        $this->maybe_behave_like_tag();
        $result = register_taxonomy(static::TAXONOMY, $this->object_types, $this->args);


        if (is_wp_error($result)) {
            if (WP_DEBUG && WP_DEBUG_LOG) {
                error_log(
                    sprintf(
                        /* translators: The first argument is the machine name of the taxonomy */
                        __('Could not register taxonomy %1$s. Error: %2$s', 'nvis-program-pages'),
                        static::TAXONOMY,
                        $result->get_error_message()
                    )
                );
            }

            return;
        }

        $this->args = [];

        return;
    }

    /**
     * Sets an update_count_callback if necessary.
     *
     * Automatically handles the update_count_callback. See:
     * @link http://codex.wordpress.org/Function_Reference/register_taxonomy#Example
     *
     * @return void
     */
    private function maybe_behave_like_tag(): void {
        if (empty($this->args['hierarchical']) || !$this->args['hierarchical']) {
            if (!isset($this->args['update_count_callback'])) {
                $this->args['update_count_callback'] = '_update_post_term_count';
            }
        }

        return;
    }

    /**
     * Gets all terms of this taxonomy.
     *
     * Wrapper for get_terms.
     *
     * @return array Array of WP_Term objects.
     */
    public function get_all(): array {
        return get_terms([
            'taxonomy'      => static::TAXONOMY,
            'hide_empty'    => false
        ]);
    }

    public static function get_content_type():string {
        return 'taxonomy';
    }

    public static function get_by_meta(string $key = '', string $value = '', string $compare = '=', bool $singular = false) {
        $terms = get_terms([
            'taxonomy' => static::TAXONOMY,
            'hide_empty' => false,
            'meta_key' => $key,
            'meta_value' => $value,
            'meta_compare' => $compare
        ]);

        if (is_wp_error($terms)) {
            return $terms;
        }

        if ($singular) {
            if (!empty($terms)) {
                return $terms[0];
            }

            return null;
        }

        return $terms;
    }
}
