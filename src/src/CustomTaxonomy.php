<?php

namespace InvisibleUs\Programs;

abstract class CustomTaxonomy extends CustomContentObject {
    /**
     * The taxonomy identifier, slug style, to supply to WordPress.
     */
    public const taxonomy = '';

    public $object_types = null;

    public $labels = [];
    /**
     * Taken right from register_taxonomy. @link https://developer.wordpress.org/reference/functions/register_taxonomy/
     * @var array
     */
    public $args = [
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

    public function __construct() {
        $this->system_name = static::taxonomy;
        parent::__construct();
    }

    public function register() {
        $this->create_labels();
        $this->maybe_behave_like_tag();
        $result = register_taxonomy(static::taxonomy, $this->object_types, $this->args);

        if (is_wp_error($result)) {
            trigger_error(
                sprintf(
                    __('Could not register taxonomy %s. Error: %s', 'rc-content-model'),
                    static::taxonomy,
                    $result->get_error_message()
                ),
                E_USER_ERROR
            );

            return;
        }
        $this->args = null;
        $this->labels = null;
    }

    protected function create_labels() {
        // recreate WordPress' default labels based around the name of the object
        $default_labels = [
            'name'                       => _x($this->plural_name, $this->plural_name, $this->text_domain),
            'singular_name'              => _x($this->name, $this->name, $this->text_domain),
            'search_items'               => __('Search '.$this->plural_name, $this->text_domain),
            'popular_items'              => __('Popular '.$this->plural_name, $this->text_domain),
            'all_items'                  => __('All '.$this->plural_name, $this->text_domain),
            'parent_item'                => __('Parent '.$this->name, $this->text_domain),
            'parent_item_colon'          => __('Parent '.$this->name.':', $this->text_domain),
            'edit_item'                  => __('Edit '.$this->name, $this->text_domain),
            'update_item'                => __('Update '.$this->name, $this->text_domain),
            'add_new_item'               => __('Add New '.$this->name, $this->text_domain),
            'new_item_name'              => __('New '.$this->name.' Name', $this->text_domain),
            'separate_items_with_commas' => __('Separate '.strtolower($this->plural_name).' with commas', $this->text_domain),
            'add_or_remove_items'        => __('Add or remove '.strtolower($this->plural_name), $this->text_domain),
            'choose_from_most_used'      => __('Choose from the most used '.strtolower($this->plural_name), $this->text_domain),
            'menu_name'                  => __($this->plural_name),
        ];

        // for category style, remove tag labels
        if (!empty($this->args['hierarchical']) && $this->args['hierarchical']) {
            $default_labels = array_merge(
                $default_labels,
                [
                    'popular_items'              => null,
                    'separate_items_with_commas' => null,
                    'add_or_remove_items'        => null,
                    'choose_from_most_used'      => null
                ]
            );
        } else { // for tag style, remove parent references
            $default_labels = array_merge(
                $default_labels,
                [
                    'parent_item'       => null,
                    'parent_item_colon' => null
                ]
            );
        }

        if ($this->labels) {
            if (is_array($this->labels)) {
                $this->labels = array_merge($default_labels, $this->labels);
            } else {
                trigger_error(
                    sprintf(
                        __('Error setting up labels for taxonomy %s. Expected class member \'labels\' to be array.', 'rc-content-model'),
                        static::taxonomy,
                        $result->get_error_message()
                    ),
                    E_USER_ERROR
                );
            }
        } else {
            $this->labels = $default_labels;
        }
        $this->args['labels'] = $this->labels;
    }

    private function maybe_behave_like_tag() {
        // Preference: automatically handles the update_count_callback for you.
        // @link http://codex.wordpress.org/Function_Reference/register_taxonomy#Example
        if (empty($this->args['hierarchical']) || !$this->args['hierarchical']) {
            if (!isset($this->args['update_count_callback'])) {
                $this->args['update_count_callback'] = '_update_post_term_count';
            }
        }

        return;
    }

    public function get_all() {
        return get_terms([
            'taxonomy'      => static::taxonomy,
            'hide_empty'    => false
        ]);
    }
}
