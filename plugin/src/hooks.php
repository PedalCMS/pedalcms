<?php
/**
 * Various global hook functions.
 *
 * @package NVISPrograms
 * @since 0.1.0
 */

namespace InvisibleUs\Programs;

add_filter('document_title_parts', __NAMESPACE__ . '\document_title_parts', 10, 3);
add_filter('body_class', __NAMESPACE__ . '\body_class', 10, 3);
add_filter('post_class', __NAMESPACE__ . '\post_class', 10, 3);
add_filter('term_link', __NAMESPACE__ . '\term_link', 10);
add_filter('nvis/programs/before_main_content', __NAMESPACE__ . '\before_main_content');
add_filter('nvis/programs/after_main_content', __NAMESPACE__ . '\after_main_content');
add_filter('nvis/template_args', __NAMESPACE__ . '\template_arg_options', 10, 2);

/**
 * Updates the title for filtered results in archives and program subpages.
 *
 * Called on filter: document_title_parts
 *
 * @param array $title The current title parts.
 */
function document_title_parts(array $title): array {
    $post_types = [
        // TODO: Add these to the objects and reference them.
        Program::POST_TYPE => 'Programs',
        Person::POST_TYPE  => 'Directory',
        Course::POST_TYPE  => 'Course Catalog',
    ];

    foreach ($post_types as $post_type => $replacement) {
        if (nvis_is_filtered_results($post_type)) {
            // TODO: centralize this text so it can be called here and in breadcrumbs.
            $title['title'] = $replacement . ' Filtered Results';

            return $title;
        }
    }

    if (is_singular(Program::POST_TYPE)) {
        $subpage = ProgramSubpageManager::get_active_subpage('object');

        if ($subpage->slug !== 'index') {
            // TODO: Make this customizable. Consider moving to subpage manager.
            $title['title'] .= ', ' . $subpage->title;

            return $title;
        }
    }

    return $title;
}

/**
 * Adds body class name based on presentation mode.
 *
 * @param array $classes An array of body class names.
 * @return array The resulting array of body class names.
 */
function body_class(array $classes): array {
    $presentation_mode = Plugin::get_option('presentation_mode');

    if ($presentation_mode) {
        $classes[] = 'nvis-present-mode--' . $presentation_mode;
    }

    return $classes;
}

/**
 * Adds a class for the current program subpage.
 *
 * @param array $classes The list of post classes.
 * @return array The filtered list of post classes.
 */
function post_class(array $classes): array {
    if (!is_admin() && is_singular(Program::POST_TYPE)) {
        $classes[] = 'subpage-' . ProgramSubpageManager::get_active_subpage();
    }

    return $classes;
}

/**
 * Changes the behavior of term links when the taxonomy does not support archives.
 *
 * Replaces the home_url with the current post type archive link except for
 * pages and posts.
 *
 * Called on: term_link
 *
 * @param string $link
 * @return string
 */
function term_link(string $link): string {
    $query_start = strpos($link, '?');

    if ($query_start !== false) {
        $post_type = get_post_type();

        if (!in_array($post_type, ['post','page'], true)) {
            $link = get_post_type_archive_link($post_type) . substr($link, $query_start);
        }
    }

    return $link;
}

/**
 * Action to output opening tag of main content wrapper.
 *
 * Called on: nvis/programs/before_main_content
 *
 * @return void
 */
function before_main_content() {
    $pattern = '<%s id="%s" class="%s">';
    $id = apply_filters('nvis/programs/main_content_wrapper_id', 'main-content-wrapper');
    $classes = ['nvis-progs-template', 'nvis-template'];
    $classes = apply_filters('nvis/careers/main_content_wrapper_class', $classes);
    $tag = Plugin::get_option('main_content_wrapper_tag');

    echo sprintf(
        $pattern,
        $tag,
        $id,
        esc_attr(implode(' ', $classes))
    );
}

/**
 * Action to output end tag of main content wrapper.
 *
 * Called on: nvis/programs/after_main_content
 *
 * @return void
 */
function after_main_content() {
    $tag = Plugin::get_option('main_content_wrapper_tag');

    echo "</{$tag}>";
}

function template_arg_options($args, $template) {
    switch ($template) {
        case 'common/post-featured-image':
            return featured_image_arg_options($args);
        default:
            break;
    }

    return $args;
}

function featured_image_arg_options($args) {
    $presentation_mode = Plugin::get_option('presentation_mode');
    $zoom_class = 'featured-image--zoom-hover';

    if (is_post_type_archive()) {
        if ($presentation_mode === 'full') {
            $args['image_wrapper_class'] = $zoom_class;
        }
    }

    if (is_singular() && empty($args['post']) || (!empty($args['post']) && $args['post'] === get_the_ID())) {
        $args['image_size'] = [450, 336];
    }

    if (is_post_type_archive(Program::POST_TYPE) || is_singular(Program::POST_TYPE)) {
        $fallback_image = Plugin::get_option('image_fallback_program');

        if ($fallback_image) {
            $args['fallback_attachment_id'] = $fallback_image;
        }
    }

    return $args;
}

add_filter('acf/load_field/name=nvis_image_size_single', function ($field) {
    $sizes = wp_get_registered_image_subsizes();
    $labels = [];

    foreach ($sizes as $key => $props) {
        $labels[] = sprintf(
            '%s (%s &times %s)',
            $key,
            $props['width'],
            $props['height']
        );
    }

    $field['choices'] = array_combine(
        array_keys($sizes),
        $labels
    );

    return $field;
});
