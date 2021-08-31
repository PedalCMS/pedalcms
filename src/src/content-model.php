<?php

namespace InvisibleUs\Programs;

add_action('init', __NAMESPACE__ . '\register_content_model');
add_action('enter_title_here', __NAMESPACE__ . '\update_enter_title_text', PHP_INT_MAX, 2);
add_action('pre_get_posts', __NAMESPACE__ . '\update_sort_order');


function register_content_model() {
    register_post_type(
        'nvis_program',
        [
            'labels' => create_post_type_labels('Program', 'Programs'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-welcome-learn-more',
            'capability_type' => 'nvis_program',
            'map_meta_cap' => true,
            // TODO: Make this dynamic.
            'has_archive' => 'programs',
            'rewrite' => ['slug' => 'program'],
            'hierarchical' => true,
            'supports' => ['title', 'thumbnail']
        ]
    );

    register_post_type(
        'nvis_course',
        [
            'labels' => create_post_type_labels('Course', 'Courses'),
            'public' => true,
            'hierarchical' => false,
            'capability_type' => 'nvis_program',
            'map_meta_cap' => true,
            'supports' => ['title', 'editor', 'custom-fields'],
            'rewrite' => ['slug' => 'course'],
            'menu_position' => 5,
            'menu_icon' => 'dashicons-book-alt',
        ]
    );

    register_post_type(
        'nvis_faq',
        [
            'labels' => create_post_type_labels('FAQ', 'FAQs'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-editor-help',
            'capability_type' => 'nvis_faq',
            'map_meta_cap' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'faq'],
            'hierarchical' => true,
            'supports' => ['title', 'editor']
        ]
    );

    register_post_type(
        'nvis_person',
        [
            'labels' => create_post_type_labels('Contact', 'Contacts'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-businesswoman',
            'capability_type' => 'nvis_person',
            'map_meta_cap' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'person'],
            'hierarchical' => false,
            'supports' => ['title', 'thumbnail']
        ]
    );

    // TODO: Is Levels a universal way to describe this?
    register_taxonomy(
        'nvis_program_type',
        'nvis_program',
        [
            'labels' => create_taxonomy_labels('Program Type', 'Program Types'),
            'query_var' => 'prog_type',
            'rewrite' => false,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_in_quick_edit' => false,
            'meta_box_cb' => false,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
        ]
    );

    register_taxonomy(
        'nvis_program_college',
        'nvis_program',
        [
            'labels' => create_taxonomy_labels('College', 'Colleges'),
            'rewrite' => false,
            'query_var' => 'prog_college',
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_quick_edit' => false,
            'meta_box_cb' => false,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
        ]
    );

    register_taxonomy(
        'nvis_program_format',
        'nvis_program',
        [
            'labels' => create_taxonomy_labels('Format', 'Formats'),
            'hierarchical' => false,
            'query_var' => 'prog_format',
            'public' => true,
            'show_ui' => true,
            'show_in_quick_edit' => false,
            'meta_box_cb' => false,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
        ]
    );

    register_taxonomy(
        'nvis_faq_cat',
        'nvis_faq',
        [
            'labels' => create_taxonomy_labels('FAQ Category', 'FAQ Categories'),
            'hierarchical' => true,
            'public' => true,
            'show_in_quick_edit' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
        ]
    );
}

// TODO: make strtolower optional.
function create_post_type_labels(string $name, string $plural_name): array {
    $text_domain = 'wp-program-pages';

    return [
        'name'               => _x($plural_name, 'post type general name', $text_domain),
        'singular_name'      => _x($name, 'post type singular name', $text_domain),
        'menu_name'          => _x($plural_name, 'admin menu', $text_domain),
        'name_admin_bar'     => _x($name, 'add new on admin bar', $text_domain),
        'add_new'            => _x('Add New', strtolower($name), $text_domain),
        'add_new_item'       => __('Add New ' . $name, $text_domain),
        'new_item'           => __('New ' . $name, $text_domain),
        'edit_item'          => __('Edit ' . $name, $text_domain),
        'view_item'          => __('View ' . $name, $text_domain),
        'all_items'          => __('All ' . strtolower($plural_name), $text_domain),
        'search_items'       => __('Search ' . strtolower($plural_name), $text_domain),
        'parent_item_colon'  => __('Parent ' . strtolower($plural_name) . ':', $text_domain),
        'not_found'          => __('No ' . strtolower($plural_name) . ' found.', $text_domain),
        'not_found_in_trash' => __('No ' . strtolower($plural_name) . ' found in Trash.', $text_domain),
    ];
}

function create_taxonomy_labels(string $name, string $plural_name): array {
    $text_domain = 'wp-program-pages';

    return [
        'name' => _x($plural_name, $plural_name, $text_domain),
        'singular_name' => _x($name, $name, $text_domain),
        'search_items' =>  __('Search ' . $plural_name, $text_domain),
        'popular_items' => __('Popular ' . $plural_name, $text_domain),
        'all_items' => __('All ' . $plural_name, $text_domain),
        'parent_item' => __('Parent ' . $name, $text_domain),
        'parent_item_colon' => __('Parent ' . $name . ':', $text_domain),
        'edit_item' => __('Edit ' . $name, $text_domain),
        'update_item' => __('Update ' . $name, $text_domain),
        'add_new_item' => __('Add New ' . $name, $text_domain),
        'new_item_name' => __('New ' . $name . ' Name', $text_domain),
        'separate_items_with_commas' => __('Separate ' . strtolower($plural_name) . ' with commas', $text_domain),
        'add_or_remove_items' => __('Add or remove ' . strtolower($plural_name), $text_domain),
        'choose_from_most_used' => __('Choose from the most used ' . strtolower($plural_name), $text_domain),
        'menu_name' => __($plural_name),
    ];
}

function update_enter_title_text(string $text, \WP_Post $post): string {
    switch ($post->post_type) {
    case 'nvis_faq':
      return 'Enter the Question';
    case 'nvis_person':
      return 'Enter the Full Name';
    default:
      return $text;

  }
}

function update_sort_order(\WP_Query $query) {
    if (is_post_type_archive('nvis_program')) {
        $query->set('order', 'ASC');
        $query->set('orderby', 'title');
    }
};

function group_faqs_by_category(array $faqs): array {
    $cats = [];

    foreach ($faqs as $faq) {
        $terms = get_the_terms($faq, 'nvis_faq_cat');
        if (is_array($terms)) {
            $cat = array_shift($terms);
            if (!isset($cats[$cat->slug])) {
                $cat->faqs = [];
                $cats[ $cat->slug ] = $cat;
            }

            $cats[$cat->slug]->faqs[] = $faq;
        }
    }

    return $cats;
}

function get_program_related_posts(mixed $program = null, array $not_in = []): array {
    $program = get_post($program);

    $tag = get_field('news_tag', $program);
    $num_posts = get_field('news_num_posts', $program);

    if (!$tag) {
        return [];
    }

    $args = [
        'tag_id' => $tag,
        'ignore_sticky_posts' => true,
        'posts_per_page' => $num_posts
    ];

    if (!empty($not_in)) {
        $args['post__not_in'] = $not_in;
    }

    return get_posts($args);
}

function get_program_application_deadlines(mixed $program = null): array {
    $program = $program ? get_post($program) : get_post();

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
