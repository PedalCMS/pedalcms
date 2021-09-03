<?php

namespace InvisibleUs\Programs;

class Program extends CustomPostType {
    /**
     * The post type to register.
     */
    public const post_type = 'nvis_program';

    /**
     * The proper name.
     *
     * @var string
     */
    public $name = 'Program';

    /**
     * The plural version of the proper name.
     *
     * @var string
     */
    public $plural_name = 'Programs';

    /**
     * The args to pass to register_post_type.
     *
     * Gets updated throughout the setup process.
     *
     * @var array
     */
    public $args = [
        'has_archive'         => 'programs',
        'rewrite'             => ['slug' => 'program', 'with_front' => true],
        'capability_type'     => self::post_type,
        'menu_icon'           => 'dashicons-welcome-learn-more',
        'menu_position'       => 5,
        'description'         => '',
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'supports'            => ['title', 'thumbnail'],
    ];

    /**
     * A list of field group arrays to pass to acf_add_local_field_group.
     *
     * @var array
     */
    public $field_groups = [

    ];

    public function setup_hooks(): void {
        add_action('pre_get_posts', [static::class, 'update_sort_order']);
    }

    public static function update_sort_order(\WP_Query $query): void {
        if (is_post_type_archive(self::post_type)) {
            $query->set('order', 'ASC');
            $query->set('orderby', 'title');
        }

        return;
    }

    public static function get_related_posts($program = null, array $not_in = []): array {
        $program = get_post($program);

        $tag = get_field('news_tag', $program);
        $num_posts = get_field('news_num_posts', $program);

        if (!$tag) {
            return [];
        }

        $args = [
            'tag_id'              => $tag,
            'ignore_sticky_posts' => true,
            'posts_per_page'      => $num_posts
        ];

        if (!empty($not_in)) {
            $args['post__not_in'] = $not_in;
        }

        return get_posts($args);
    }

    public static function get_application_deadlines($program = null): array {
        $program = get_post($program);

        // First, check if the program has specific deadlines.
        $deadlines = get_field('application_deadlines', $program);

        if (!empty($deadlines)) {
            return $deadlines;
        }

        // Then, check if either the college or the program type has overriden.
        $terms = ['college','program_type'];

        foreach ($terms as $name) {
            $term = get_field($name, $program);

            if (!empty($term)) {
                $deadlines = get_field('application_deadlines', $term);

                if (!empty($deadlines)) {
                    return $deadlines;
                }
            }
        }

        // If all else fails, just return the global setting.
        return get_field('nvis_application_deadlines', 'option');
    }
}
