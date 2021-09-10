<?php

namespace InvisibleUs\Programs;

class Person extends CustomPostType {
    /**
     * The post type to register.
     */
    public const post_type = 'nvis_person';

    /**
     * The proper name.
     *
     * @var string
     */
    public $name = 'Faculty & Staff';

    /**
     * The plural version of the proper name.
     *
     * @var string
     */
    public $plural_name = 'Faculty & Staff';

    /**
     * The replacement text for enter_title_here filter.
     *
     * @var string
     */
    public static $enter_title_text = 'Enter the Full Name';

    /**
     * The args to pass to register_post_type.
     *
     * Gets updated throughout the setup process.
     *
     * @var array
     */
    public $args = [
        'rewrite'             => ['slug' => 'person'],
        'has_archive'         => 'people',
        'capability_type'     => self::post_type,
        'menu_icon'           => 'dashicons-businesswoman',
        'menu_position'       => 5,
        'description'         => '',
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'supports'            => ['title', 'editor', 'thumbnail'],
    ];

    /**
     * Takes a list of People and returns them indexed by category.
     *
     * @param array $people A list of People of the type WP_Post.
     * @return array The category indexed list of people.
     */
    public static function group_by_category(array $people): array {
        $cats = [];

        foreach ($people as $person) {
            $terms = get_the_terms($person, PersonCategory::taxonomy);

            if (is_array($terms)) {
                // We only care about the first category they are in.
                $cat = array_shift($terms);

                if (!isset($cats[$cat->slug])) {
                    $cat->people = [];
                    $cats[ $cat->slug ] = $cat;
                }

                $cats[$cat->slug]->people[] = $person;
            }
        }

        return $cats;
    }
}
