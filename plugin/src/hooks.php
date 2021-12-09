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
    $classes[] = 'presentation-mode--' . Plugin::get_option('presentation_mode');
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
