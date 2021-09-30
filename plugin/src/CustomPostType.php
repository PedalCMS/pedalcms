<?php

namespace InvisibleUs\Programs;

/**
 * Base class for common custom post type tasks in WordPress.
 * 
 * @version 0.1.0
 * @package nvis-programs
 * @since 0.1.0
 */
abstract class CustomPostType extends CustomContentObject {
    /**
     * The machine name of the CPT.
     */
    public const POST_TYPE = '';

    /**
     * The path to a custom icon file.
     *
     * @var string
     */
    public string $icon_file = '';

    /**
     * The custom fields to register via register_post_meta.
     *
     * @var array
     */
    public static array $post_meta = [];

    /**
     * The WP_Post_Type object returned by register_post_type. 
     *
     * @var object|null
     */
    public ?object $post_object = null;

    /**
     * Whether or not it is safe to lowercase the post type's name. 
     *
     * @var boolean
     */
    public bool $lowercase_safe = false;

    /**
     * The placeholder text to replace 'Add title' in the edit screen.
     *
     * @var string
     */
    public static string $enter_title_text = '';

    /**
     * The base path to look for icon files. Relative to the plugin root.
     *
     * @var string
     */
    protected string $icons_path = 'icons/';


    public function __construct() {
        parent::__construct();
        $this->system_name = static::POST_TYPE;

        return;
    }

    /**
     * A helper function to avoid overriding the register function. 
     *
     * @return void
     */
    public function setup_hooks(): void {
        return;
    }

    /**
     * Callback that fires on enter_title_here when necessary. 
     *
     * @param string $text
     * @param \WP_Post $post
     * @return string
     */
    public static function update_enter_title_text(string $text, \WP_Post $post): string {
        if ($post->post_type === static::POST_TYPE) {
            $text = static::$enter_title_text;
        }

        return $text;
    }

    /**
     * Registers the post type.
     * 
     * Does the prep, registers the post type, and then additional setup work. 
     *
     * @return void
     */
    public function register(): void {
        parent::register();
        $this->maybe_load_icon();
        $this->post_object = register_post_type(static::POST_TYPE, $this->args);
        // After we register the post type, the args and labels are redundant.
        $this->args = [];
        $this->labels = [];
        $this->maybe_register_meta();
        $this->setup_hooks();

        if (static::$enter_title_text) {
            add_action('enter_title_here', [static::class, 'update_enter_title_text'], 10, 2);
        }

        return;
    }

    /**
     * Registers any post_meta fields if necessary.
     *
     * @return void
     */
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

    /**
     * Loads the appropriate icon file path into the args array if necessary.
     *
     * @return void
     */
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

    /**
     * Gets all posts of post_type. 
     * 
     * Wrapper for get_posts.
     *
     * @param string $post_status Published status to restrict list.
     * @return array|WP_Error Array of WP_Post objects
     */
    public static function get_all(string $post_status = 'any'): array {
        $posts = get_posts([
            'post_type'     => static::POST_TYPE,
            'nopaging'      => true,
            'post_status'   => $post_status
        ]);

        return $posts;
    }

    /**
     * Gets all posts of post_type by given post_name.
     * 
     * Wrapper for get_posts.
     *
     * @param string $slug The post_name of the post to find.
     * @return array|WP_Error Array of WP_Post objects
     */
    public static function get_by_slug(string $slug): array {
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

    /**
     * Gets all posts of post_type by given meta args.
     * 
     * Wrapper for get_posts that builds the meta_query arg.
     *
     * @param string $key The meta_key to search.
     * @param string $value The meta_value to match.
     * @param string $compare The compare operator.
     * @param integer $limit Max number of posts to return.
     * @return array|WP_Error Array of WP_Post objects
     */
    public static function get_by_meta(string $key = '', string $value = '', string $compare = '=', int $limit = 1): array {
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

    /**
     * Whether post_type's add/edit screen is the current screen. 
     *
     * @return boolean
     */
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

    /**
     * Whether post_type's list screen is the current screen.
     *
     * @return boolean
     */
    public static function is_edit_screen() {
        if (!function_exists('get_current_screen')) {
            return null;
        }
        $screen = get_current_screen();

        return $screen->parent_base === 'edit' && $screen->id === static::POST_TYPE;
    }

    /**
     * Groups a list of posts by a given taxonomy.
     * 
     * Returned list is a WP_Term objects with an additional property, the name
     * of which is the $index parameter. 
     * 
     * **Important:** 
     * Only matches the _first_ term for the given taxonomy. If the post is in 
     * multiple terms, it will only be grouped into the first one. 
     *
     * @param array $posts List of WP_Post objects. 
     * @param string $taxonomy The name of the taxonomy to group by.
     * @param string $index The key to list the posts in.
     * @return array List of WP_Term objects with posts added.
     */
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
