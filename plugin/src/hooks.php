<?php
/**
 * Various global hook functions.
 *
 * @package NVISPrograms
 * @since 0.1.0
 */

namespace InvisibleUs\Programs;

add_filter('document_title_parts', __NAMESPACE__ . '\document_title_parts', 10, 3);
add_filter('nvis/programs/before_main_content', __NAMESPACE__ . '\before_main_content');
add_filter('nvis/programs/after_main_content', __NAMESPACE__ . '\after_main_content');

/**
 * Updates the title for filtered results in archives.
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
        if (nvis_prog_is_filtered_results($post_type)) {
            // TODO: centralize this text so it can be called here and in breadcrumbs.
            $title['title'] = $replacement . ' Filtered Results';

            return $title;
        }
    }

    // TODO: Add support for Program subpages.

    return $title;
}

function before_main_content() {
    $pattern = '<%s id="%s" class="%s" %s>';
    $id = apply_filters('nvis/programs/main_content_wrapper_id', 'main-content-wrapper');
    $classes = apply_filters('nvis/programs/main_content_wrapper_class', ['nvis-progs-template']);
    $tag = Plugin::get_option('main_content_wrapper_tag');
    $role = ($tag === 'main') ? 'role="main"' : '';

    echo sprintf(
        $pattern,
        $tag,
        $id,
        implode(' ', $classes),
        $role
    );
}

function after_main_content() {
    $tag = Plugin::get_option('main_content_wrapper_tag');

    echo "</{$tag}>";
}
