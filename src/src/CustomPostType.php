<?php

namespace InvisibleUs\Programs;

abstract class CustomPostType extends CustomContentObject {
    public const post_type = '';

    public $icon_file = '';

    public $labels = [];

    public $args = [];

    public $post_object = null;

    protected $icons_path = 'icons/';


    public function __construct() {
        parent::__construct();
        $this->system_name = static::post_type;
    }

    public function register() {
        parent::register();
        $this->create_labels();
        $this->maybe_load_icon();
        $this->post_object = register_post_type(static::post_type, $this->args);
        // After we register the post type the args and labels are redundant
        $this->args = null;
        $this->labels = null;
    }

    protected function create_labels() {
        $default_labels = [
            'name'               => _x($this->plural_name, 'post type general name', $this->text_domain),
            'singular_name'      => _x($this->name, 'post type singular name', $this->text_domain),
            'menu_name'          => _x($this->plural_name, 'admin menu', $this->text_domain),
            'name_admin_bar'     => _x($this->name, 'add new on admin bar', $this->text_domain),
            'add_new'            => _x('Add New', strtolower($this->name), $this->text_domain),
            'add_new_item'       => __('Add New ' . $this->name, $this->text_domain),
            'new_item'           => __('New ' . $this->name, $this->text_domain),
            'edit_item'          => __('Edit ' . $this->name, $this->text_domain),
            'view_item'          => __('View ' . $this->name, $this->text_domain),
            'all_items'          => __('All '. strtolower($this->plural_name), $this->text_domain),
            'search_items'       => __('Search '. strtolower($this->plural_name), $this->text_domain),
            'parent_item_colon'  => __('Parent '. strtolower($this->plural_name) . ':', $this->text_domain),
            'not_found'          => __('No '. strtolower($this->plural_name) . ' found.', $this->text_domain),
            'not_found_in_trash' => __('No '. strtolower($this->plural_name) . ' found in Trash.', $this->text_domain)
        ];

        if ($this->labels) {
            if (is_array($this->labels)) {
                $this->labels = array_merge($default_labels, $this->labels);
            } else {
                trigger_error(
                    sprintf(
                        __('Error setting up labels for custom post type %s. Expected class member \'labels\' to be array.', 'rc-content-model'),
                        static::post_type
                    ),
                    E_USER_ERROR
                );
            }
        } else {
            $this->labels = $default_labels;
        }
        $this->args['labels'] = $this->labels;
    }


    protected function maybe_load_icon() {
        if (!$this->icon_file) {
            return;
        }

        $file = null;

        $default_path = trailingslashit(Plugin::$path) . $this->icons_path;

        if (is_file($this->icon_file)) {
            $file = $this->icon_file;
        } elseif (is_file($default_path.$this->icon_file)) {
            $file = $default_path.$this->icon_file;
        }

        if ($file) {
            $this->args['menu_icon'] = $file;
        }
    }

    public function get_all($post_status = 'any') {
        $posts = get_posts([
            'post_type'     => static::post_type,
            'nopaging'      => true,
            'post_status'   => $post_status
        ]);

        return $posts;
    }

    public static function get_by_slug($slug) {
        $posts = get_posts([
            'post_type'     => static::post_type,
            'numberposts'   => 1,
            'post_status'   => 'any',
            'name'          => $slug
        ]);

        if (is_wp_error($posts)) {
            return $posts;
        }

        if (!empty($posts)) {
            return $posts[0];
        }

        return false;
    }

    public static function get_by_meta($key = '', $value = '', $compare = '=', $limit = 1) {
        $posts = get_posts([
            'post_type'     => static::post_type,
            'numberposts'   => $limit,
            'post_status'   => 'any',
            'meta_query'    => [
                [
                    'key'     => $key,
                    'value'   => $value,
                    'compare' => $compare
                ]
            ]
        ]);

        if (is_wp_error($posts) || empty($posts)) {
            return $posts;
        }

        if (!empty($posts)) {
            if (1 === $limit) {
                return $posts[0];
            }
        }

        return false;
    }

    public function is_edit_posts_screen() {
        global $pagenow;

        if ($pagenow == 'edit.php') {
            if (!empty($_GET['post_type'])) {
                if ($_GET['post_type'] == static::post_type) {
                    return true;
                }
            }
        }

        return false;
    }

    public function is_edit_screen() {
        if (!function_exists('get_current_screen')) {
            return null;
        }
        $screen = get_current_screen();

        return $screen->parent_base === 'edit' && $screen->id === static::post_type;
    }
}
