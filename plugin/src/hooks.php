<?php
/**
 * Various global hook functions.
 *
 * @package NVISPrograms
 * @since 0.1.0
 */

namespace InvisibleUs\Programs;

add_filter('document_title_parts', __NAMESPACE__ . '\document_title_parts', 10, 3);
add_action('wp_head', __NAMESPACE__ . '\options_wp_head', 7);
add_filter('body_class', __NAMESPACE__ . '\body_class', 10, 3);
add_filter('admin_body_class', __NAMESPACE__ . '\admin_body_class', 10, 3);
add_filter('post_class', __NAMESPACE__ . '\post_class', 10, 3);
add_filter('term_link', __NAMESPACE__ . '\term_link', 10);
add_filter('nvis/programs/before_main_content', __NAMESPACE__ . '\before_main_content');
add_filter('nvis/programs/after_main_content', __NAMESPACE__ . '\after_main_content');
add_filter('post_type_archive_title', __NAMESPACE__ . '\options_post_type_archive_title', 5, 2);
add_filter('get_the_post_type_description', __NAMESPACE__ . '\options_post_type_description', 5, 2);
add_filter('taxonomy_labels_nvis_program_type', __NAMESPACE__ . '\options_program_type_labels');
add_filter('taxonomy_labels_nvis_college', __NAMESPACE__ . '\options_college_labels');
add_filter('taxonomy_labels_nvis_instruct_mode', __NAMESPACE__ . '\options_instruct_mode_labels');
add_filter('taxonomy_labels_nvis_subject', __NAMESPACE__ . '\options_subject_labels');
add_filter('taxonomy_labels_nvis_session', __NAMESPACE__ . '\options_session_labels');
add_filter('taxonomy_labels_nvis_person_cat', __NAMESPACE__ . '\options_person_cat_labels');
add_filter('taxonomy_labels_nvis_department', __NAMESPACE__ . '\options_department_labels');
add_filter('taxonomy_labels_nvis_faq_cat', __NAMESPACE__ . '\options_faq_cat_labels');
add_filter('nvis/template_defaults', __NAMESPACE__ . '\options_template_defaults', 5, 2);
add_filter('nvis/template_args', __NAMESPACE__ . '\options_template_args', 5, 2);
add_filter('nvis/get_label', __NAMESPACE__ . '\options_plugin_labels', 5, 3);
add_filter('nvis/programs/add_subpage', __NAMESPACE__ . '\options_subpage_labels', 5, 2);


/**
 * Updates the title for filtered results in archives and program subpages.
 *
 * Called on filter: document_title_parts
 *
 * @param array $title The current title parts.
 */
function document_title_parts(array $title): array {

    if (nvis_is_filtered_results(Plugin::post_types())) {
        $post_type = get_post_type();
        /**
         * Filters the format of the document title part of filtered post type archives.
         *
         * @param $format The format of the document title part.
         * @param $post_type The current post type.
         */
        $format = apply_filters(
            'nvis/filter_results_document_title_format',
            '%1$s, %2$s',
            $post_type
        );

        /**
         * Filters the label indicating 'Filtered Results' in the document title.
         *
         * @param $label The filtered results label.
         * @param $post_type The current post type.
         */
        $filtered_label = apply_filters(
            'nvis/filtered_results_document_title_label',
            Plugin::get_label('filtered_results'),
            $post_type
        );

        $title['title'] = sprintf(
            $format,
            post_type_archive_title('', false),
            $filtered_label
        );

        return $title;
    }

    return $title;
}

function options_wp_head() {
    $style_tag = '<style>body .nvis-template{%s}</style>';
    $var_ptrn = '--nvis-%s: %s';
    $options = [
        'active_color',
        'active_color_text'
    ];
    $vars = [];

    foreach($options as $option) {
        $value = Plugin::get_option($option);

        if ($value) {
            $vars[] = sprintf(
                $var_ptrn,
                str_replace('_', '-', $option),
                $value
            );
        }
    };

    if (!empty($vars)) {
        echo sprintf(
            $style_tag,
            implode(';', $vars)
        );
    }
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
 * Adds body class name based on presentation mode to options screen.
 *
 * @param string $classes A string of body class names.
 * @return string The resulting string of body class names.
 */
function admin_body_class(string $classes): string {
    $current_screen = get_current_screen();
    if ($current_screen->id === 'settings_page_' . Plugin::$options_page_slug) {
        $presentation_mode = Plugin::get_option('presentation_mode');

        if ($presentation_mode) {
            $classes .= ' nvis-present-mode--' . $presentation_mode;
        }
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
        $classes[] =
            'subpage-' .
            Program::subpage_manager()->get_active_subpage();
    }

    return $classes;
}

/**
 * Changes the behavior of term links when the taxonomy does not support archives.
 *
 * Replaces the home_url with the current post type archive link except for
 * pages and posts.
 *
 * Called on filter: `term_link`
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

function options_program_type_labels($labels) {
    return options_taxonomy_labels($labels, ProgramType::TAXONOMY);
}

function options_college_labels($labels) {
    return options_taxonomy_labels($labels, College::TAXONOMY);
}

function options_instruct_mode_labels($labels) {
    return options_taxonomy_labels($labels, InstructionMode::TAXONOMY);
}

function options_subject_labels($labels) {
    return options_taxonomy_labels($labels, Subject::TAXONOMY);
}

function options_session_labels($labels) {
    return options_taxonomy_labels($labels, Session::TAXONOMY);
}

function options_person_cat_labels($labels) {
    return options_taxonomy_labels($labels, PersonCategory::TAXONOMY);
}

function options_department_labels($labels) {
    return options_taxonomy_labels($labels, Department::TAXONOMY);
}

function options_faq_cat_labels($labels) {
    return options_taxonomy_labels($labels, FAQCategory::TAXONOMY);
}

function options_taxonomy_labels($labels, $taxonomy) {
    $tax = str_replace('nvis_', '', $taxonomy);

    $single = Plugin::get_option($tax . '_label_single');
    $plural = Plugin::get_option($tax . '_label_plural');

    if ($single) {
        $labels->singular_name = $single;
    }

    if ($plural) {
        $labels->name = $plural;
    }

    return $labels;
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

function options_template_args($args, $template) {
    switch ($template) {
        case 'common/filters':
            return options_search_filters($args);

        case 'common/action-list':
            return options_action_list($args);
        default:
            break;
    }

    return $args;
}

function options_search_filters($args) {
    $post_type = str_replace('nvis_', '', get_post_type());
    $enabled = Plugin::get_option($post_type . '_archive_search_filters');

    if (!is_array($enabled)) {
        $enabled = [];
    }

    $args['filters'] = [];

    $tax_filters_map = Plugin::get_tax_filters_map();

    foreach ($enabled as $filter) {
        if (array_key_exists($filter, $tax_filters_map)) {
            if (taxonomy_exists($tax_filters_map[$filter])) {
                $args['filters'][] = $filter;
            }
        } else {
            $args['filters'][] = $filter;
        }
    }

    $args['break_filters_after'] = (int) Plugin::get_option($post_type . '_archive_filters_showing');

    return $args;
}


function options_post_type_archive_title($title, $post_type) {
    if (in_array($post_type, Plugin::post_types())) {
        $post_type = str_replace('nvis_', '', $post_type);
        $new_title = Plugin::get_option($post_type . '_archive_title');

        if ($new_title) {
            $title = esc_html($new_title);
        }
    }
    return $title;
}

/**
 * Updates the post type description based on plugin option.
 *
 * Called on filter: `get_the_post_type_description`
 *
 * @since 0.1.0
 *
 * @param string $description The post type description.
 * @param WP_Post_Type $post_type The current post type object.
 * @return string The filtered post type description.
 */
function options_post_type_description($description,  $post_type_obj) {
    if (in_array($post_type_obj->name, Plugin::post_types())) {
        $post_type = str_replace('nvis_', '', $post_type_obj->name);
        $new_desc = Plugin::get_option($post_type . '_archive_description');

        if ($new_desc) {
            $description = wp_kses($new_desc, wp_kses_allowed_html('post'));
        }
    }
    return $description;
}


/**
 * Updated the template defaults based on the plugin options.
 *
 * Called on filter: `nvis/template_defaults`
 *
 * @param array $defaults The template defaults.
 * @param string $template The name of the template.
 * @return array The filtered defaults.
 */
function options_template_defaults($defaults, $template) {
    $post_type = str_replace('nvis_', '', get_post_type());
    $presentation_mode = Plugin::get_option('presentation_mode');

    switch($template) {
        case 'common/breadcrumbs':
            $defaults['show_breadcrumbs'] = Plugin::get_option('display_breadcrumbs');

            break;
        case 'common/page-header-backdrop':
            $defaults = options_page_header_backdrop($defaults, $post_type, $presentation_mode);

            break;
        case 'common/post-type-featured-image':
            $defaults = options_post_type_featured_image($defaults, $post_type);

            break;
        case 'common/post-featured-image':
            $defaults = options_post_featured_image($defaults, $post_type, $presentation_mode);

            break;
        case 'single-program/contact':
            $defaults = options_program_contact($defaults);

            break;
        case 'single-program/courses-table':
            $show_credits = Plugin::get_option('program_subpage_curriculum_show_credits');

            if (in_array($show_credits,['0','1'])) {
                $defaults['show_credits'] = (bool) $show_credits;
            }

            break;
        
        case 'single-person/related-courses':
            $label = 'label_courses_taught';
            $value = Plugin::get_option('person_' . $label);

            if ($value) {
                $defaults[$label] = $value;
            }

            break;
        default:
            break;
    }

    return $defaults;
}


function options_post_type_featured_image($defaults, $post_type) {
    $defaults['featured_img'] = Plugin::get_option($post_type . '_archive_featured_image');
    $defaults['image_size'] = Plugin::get_option('image_size_header');

    if ($defaults['image_size'] === 'custom') {
        $defaults['image_size'] = [
            (int) Plugin::get_option('image_size_header_w'),
            (int) Plugin::get_option('image_size_header_h'),
        ];
    }

    return $defaults;
}

/**
 * Filters the template defaults for `common/post-featured-image` based on plugin options.
 *
 * @param array $defaults The template defaults.
 * @return array The filtered defaults.
 */
function options_post_featured_image($defaults, $post_type, $presentation_mode) {
    $zoom_class = 'featured-image--zoom-hover';
    $post_types = Plugin::post_types();

    if (is_post_type_archive($post_types) || is_singular($post_types)) {
        $defaults['fallback_attachment_id'] = Plugin::get_option($post_type . '_featured_image');

        if (is_post_type_archive()) {
            $defaults['show_image'] = Plugin::get_option($post_type . '_archive_show_images');

            if ($presentation_mode === 'full') {
                $defaults['image_wrapper_class'] = $zoom_class;
            }
        }

        if (is_singular()) {
            $defaults['image_size'] = Plugin::get_option('image_size_header');
            if ($defaults['image_size'] === 'custom') {
                $defaults['image_size'] = [
                    (int) Plugin::get_option('image_size_header_w'),
                    (int) Plugin::get_option('image_size_header_h'),
                ];
            }
        }
    }

    return $defaults;
}

function options_page_header_backdrop($defaults, $post_type, $presentation_mode) {
    if ($presentation_mode !== 'full') {
        return $defaults;
    }

    $defaults['show_backdrop'] = true;
    $defaults['attachment_id'] = Plugin::get_option($post_type . '_archive_header_background');

    if (is_singular()) {
        $img = get_post_thumbnail_id();

        if ($img) {
            $defaults['attachment_id'] = $img;
        } else {
            $img = Plugin::get_option($post_type . '_default_featured_image');

            if ($img) {
                $defaults['attachment_id'] = $img;
            }
        }

    }

    return $defaults;
}


function options_subpage_labels($subpage, $post_type) {
    $option_prefix = sprintf(
        '%s_subpage_%s_',
        str_replace('nvis_', '', $post_type),
        str_replace('-', '_', $subpage->slug)
    );

    $labels = [
        'title',
        'tab_label'
    ];

    foreach ($labels as $label) {
        $value = Plugin::get_option($option_prefix . $label);

        if ($value) {
            $subpage->{$label} = $value;
        }
    }

    return $subpage;
}


function options_action_list($args) {
    switch ($args['context']) {
        case 'single-program/program-actions':
            $prefix = 'program';
            break;
        case 'single-course/course-actions':
            $prefix = 'course';
            break;
        default:
            $prefix = false;
    }

    if ($prefix) {
        foreach ($args['actions'] as &$action) {
            $value = Plugin::get_option("{$prefix}_label_{$action['key']}_action");

            if ($value) {
                $action['label'] = $value;
            }
        }
    }

    return $args;
}

function options_plugin_labels($label, $label_key, $plugin) {
    $course_labels = [
        'credit',
        'credits'
    ];

    if ($plugin === 'programs' && in_array($label_key, $course_labels)) {

        $value = Plugin::get_option('course_label_' . $label_key);

        if ($value) {
            $label = $value;
        }

    }

    return $label;
}


function options_program_contact($defaults) {
    $labels = [
        'label_program_contact',
        'label_contact_action',
    ];

    foreach ($labels as $label) {
        $value = Plugin::get_option('program_' . $label);

        if ($value) {
            $defaults[$label] = $value;
        }
    }

    return $defaults;
}
