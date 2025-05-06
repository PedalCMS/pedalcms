<?php

namespace PedalCMS\Core;

/**
 * Base class for common custom post type tasks in WordPress.
 *
 * @version 0.1.0
 * @package PedalCMS\StandardLib
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
    public array $post_meta = [];

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
    protected string $icons_path = 'admin/icons/';

    /**
     * @inheritdoc
     */
    protected function __construct() {
        $this->system_name = static::POST_TYPE;
        parent::__construct();
        $this->setup_post_meta();
        $this->setup_template();
        $this->setup_icon();
        $this->init();
        $this->init = true;
        return;
    }

    /**
     * Used to initialize the post_meta for post types that use it.
     *
     * @return void
     *
     */
    protected function setup_post_meta() {

    }

    /**
     * Used to initialize the block template for post types that use it.
     *
     * @return void
     */
    protected function setup_template() {

    }

    /**
     * Loads the appropriate icon file path into the args array if necessary.
     *
     * @return void
     */
    protected function setup_icon(): void {
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
            $url = trailingslashit(Plugin::$url) . $this->icons_path . $this->icon_file;
            $this->args['menu_icon'] = $url;
        }

        return;
    }

    /**
     * Registers the post type.
     *
     * Registers the post type and then additional setup work.
     *
     * @return void
     */
    public function register(): void {
        $result = register_post_type(static::POST_TYPE, $this->args);

        if (is_wp_error($result)) {
            if (WP_DEBUG && WP_DEBUG_LOG) {
                error_log(
                    sprintf(
                         /* translators: The first argument is the machine name of the post type */
                        __('Could not register post type %1$s. Error: %2$s', 'pedalcms'),
                        static::POST_TYPE,
                        $result->get_error_message()
                    )
                );
            }

            return;
        }

        $this->register_meta();
        $this->setup_hooks();

        if (static::$enter_title_text) {
            add_action('enter_title_here', [static::class, 'update_enter_title_text'], 10, 2);
        }

        return;
    }

    /**
     * Adds callbacks to hooks.
     *
     * @return void
     */
    public function setup_hooks(): void {

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
     * Registers any post_meta fields if necessary.
     *
     * @return void
     */
    public function register_meta(): void {
        if (empty($this->post_meta)) {
            return;
        }

        foreach ($this->post_meta as $meta_key => $args) {
            register_post_meta(static::POST_TYPE, $meta_key, $args);
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
     * Gets the post by given post_name field.
     *
     * Shortcut for get_posts.
     *
     * @param string $slug The post_name of the post to find.
     * @return WP_Post|WP_Error|false WP_Post object on success, false if not found, WP_Error otherwise.
     */
    public static function get_by_slug(string $slug) {
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
     * @return WP_Post|WP_Error|false WP_Post object on success, false if not found, WP_Error otherwise.
     */
    public static function get_by_meta(string $key = '', string $value = '', string $compare = '=', bool $singular = false) {
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

        if (is_wp_error($posts)) {
            return $posts;
        }

        if ($singular) {
            if (!empty($posts)) {
                return $posts[0];
            }

            return null;
        }

        return $posts;
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

    /**
     * @inheritdoc
     */
    public static function get_content_type():string {
        return 'post_type';
    }
}
