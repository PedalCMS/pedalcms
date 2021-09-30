<?php

namespace InvisibleUs\Programs;

abstract class CustomPostType extends CustomContentObject {
    public const POST_TYPE = '';

    public $icon_file = '';

    public $labels = [];

    public $args = [];

    public static $post_meta = [];

    public $post_object = null;

    public $lowercase_safe = false;

    public static $enter_title_text = '';

    protected $icons_path = 'icons/';


    public function __construct() {
        parent::__construct();
        $this->system_name = static::POST_TYPE;

        return;
    }

    public function setup_hooks(): void {
        return;
    }

    public static function update_enter_title_text(string $text, \WP_Post $post): string {
        if ($post->post_type === static::POST_TYPE) {
            $text = static::$enter_title_text;
        }

        return $text;
    }

    public function register(): void {
        parent::register();
        $this->maybe_load_icon();
        $this->post_object = register_post_type(static::POST_TYPE, $this->args);
        // After we register the post type, the args and labels are redundant.
        $this->args = null;
        $this->labels = null;
        $this->maybe_register_meta();
        $this->setup_hooks();

        if (static::$enter_title_text) {
            add_action('enter_title_here', [static::class, 'update_enter_title_text'], 10, 2);
        }

        return;
    }

    public function maybe_register_meta(): void {
        if (empty(static::$post_meta)) {
            return;
        }

        foreach (static::$post_meta as $meta_key => $args) {
            register_post_meta(static::POST_TYPE, $meta_key, $args);
        }

        return;
    }

    protected function create_labels(): void {
        $lower_singular = $this->lowercase_safe ? strtolower($this->name) : $this->name;
        $lower_plural = $this->lowercase_safe ? strtolower($this->plural_name) : $this->plural_name;

        $default_labels = [
            'name'               => _x($this->plural_name, 'post type general name', $this->text_domain),
            'singular_name'      => _x($this->name, 'post type singular name', $this->text_domain),
            'menu_name'          => _x($this->plural_name, 'admin menu', $this->text_domain),
            'name_admin_bar'     => _x($this->name, 'add new on admin bar', $this->text_domain),
            'add_new'            => _x('Add New', $lower_singular, $this->text_domain),
            'add_new_item'       => __('Add New ' . $this->name, $this->text_domain),
            'new_item'           => __('New ' . $this->name, $this->text_domain),
            'edit_item'          => __('Edit ' . $this->name, $this->text_domain),
            'view_item'          => __('View ' . $this->name, $this->text_domain),
            'all_items'          => __('All '. $lower_plural, $this->text_domain),
            'search_items'       => __('Search '. $lower_plural, $this->text_domain),
            'parent_item_colon'  => __('Parent '. $lower_plural . ':', $this->text_domain),
            'not_found'          => __('No '. $lower_plural . ' found.', $this->text_domain),
            'not_found_in_trash' => __('No '. $lower_plural . ' found in Trash.', $this->text_domain)
        ];

        if ($this->labels) {
            if (is_array($this->labels)) {
                $this->labels = array_merge($default_labels, $this->labels);
            } else {
                trigger_error(
                    sprintf(
                        __('Error setting up labels for custom post type %s. Expected class member \'labels\' to be array.', 'rc-content-model'),
                        static::POST_TYPE
                    ),
                    E_USER_ERROR
                );
            }
        } else {
            $this->labels = $default_labels;
        }
        $this->args['labels'] = $this->labels;

        return;
    }


    protected function maybe_load_icon(): void {
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

        return;
    }

    public static function get_all($post_status = 'any'): array {
        $posts = get_posts([
            'post_type'     => static::POST_TYPE,
            'nopaging'      => true,
            'post_status'   => $post_status
        ]);

        return $posts;
    }

    public static function get_by_slug($slug): array {
        $posts = get_posts([
            'post_type'     => static::POST_TYPE,
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
            'post_type'     => static::POST_TYPE,
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

    public static function is_edit_posts_screen(): bool {
        global $pagenow;

        if ($pagenow == 'edit.php') {
            if (!empty($_GET['post_type'])) {
                if ($_GET['post_type'] == static::POST_TYPE) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function is_edit_screen() {
        if (!function_exists('get_current_screen')) {
            return null;
        }
        $screen = get_current_screen();

        return $screen->parent_base === 'edit' && $screen->id === static::POST_TYPE;
    }

    public static function group_by_tax(array $posts, string $taxonomy, string $index = 'posts'): array {
        $groups = [];

        foreach ($posts as $post) {
            $terms = get_the_terms($post, $taxonomy);

            if (is_array($terms)) {
                $term = array_shift($terms);

                if (!isset($groups[$term->slug])) {
                    $term->{$index} = [];
                    $groups[ $term->slug ] = $term;
                }
                $groups[$term->slug]->{$index}[] = $post;
            }
        }

        return $groups;
    }
}
