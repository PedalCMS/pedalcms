<?php
/**
 * Various global hook functions.
 *
 * @package PedalCMS
 * @since 0.1.0
 */

namespace PedalCMS\Core;
add_filter('register_taxonomy_args', __NAMESPACE__ . '\options_register_taxonomy_args', 5, 2);
add_filter('registered_taxonomy', __NAMESPACE__ . '\options_registered_taxonomy', 5, 2);
add_filter('document_title_parts', __NAMESPACE__ . '\document_title_parts', 10, 3);
add_action('wp_head', __NAMESPACE__ . '\options_wp_head', 7);
add_filter('body_class', __NAMESPACE__ . '\body_class', 10, 3);
add_filter('admin_body_class', __NAMESPACE__ . '\admin_body_class', 10, 3);
add_filter('post_class', __NAMESPACE__ . '\post_class', 10, 3);
add_filter('term_link', __NAMESPACE__ . '\term_link', 10);
add_filter('pdl/before_main_content', __NAMESPACE__ . '\before_main_content');
add_filter('pdl/after_main_content', __NAMESPACE__ . '\after_main_content');
add_filter('post_type_archive_title', __NAMESPACE__ . '\options_post_type_archive_title', 5, 2);
add_filter('get_the_post_type_description', __NAMESPACE__ . '\options_post_type_description', 5, 2);
add_filter('taxonomy_labels_pdl_program_type', __NAMESPACE__ . '\options_program_type_labels');
add_filter('taxonomy_labels_pdl_college', __NAMESPACE__ . '\options_college_labels');
add_filter('taxonomy_labels_pdl_instruct_mode', __NAMESPACE__ . '\options_instruct_mode_labels');
add_filter('taxonomy_labels_pdl_subject', __NAMESPACE__ . '\options_subject_labels');
add_filter('taxonomy_labels_pdl_session', __NAMESPACE__ . '\options_session_labels');
add_filter('taxonomy_labels_pdl_person_cat', __NAMESPACE__ . '\options_person_cat_labels');
add_filter('taxonomy_labels_pdl_department', __NAMESPACE__ . '\options_department_labels');
add_filter('taxonomy_labels_pdl_faq_cat', __NAMESPACE__ . '\options_faq_cat_labels');
add_filter('pdl/template_defaults', __NAMESPACE__ . '\options_template_defaults', 5, 2);
add_filter('pdl/template_args', __NAMESPACE__ . '\options_template_args', 5, 2);
add_filter('pdl/get_label', __NAMESPACE__ . '\options_plugin_labels', 5, 3);
add_filter('pdl/add_subpage', __NAMESPACE__ . '\options_subpage_labels', 5, 2);

/**
 * Modifies the taxonomy args based on plugin options.
 *
 * Called on filter: `registered_taxonomy`
 *
 * @since 0.1.0
 *
 * @param array $args Array of arguments for registering a taxonomy.
 *                       See the register_taxonomy() function for accepted arguments.
 * @param string $taxonomy Taxonomy key.
 * @return array
 */
function options_register_taxonomy_args(array $args, string $taxonomy): array {
    $archive_taxonomies = [
        College::TAXONOMY,
        Department::TAXONOMY,
        ProgramType::TAXONOMY,
        PersonCategory::TAXONOMY,
    ];

    if (!in_array($taxonomy, $archive_taxonomies)) {
        return $args;
    }

    $taxonomy = str_replace('pdl_', '', $taxonomy);
    $enable_archive = Plugin::get_option($taxonomy . '_enable_archive');

    if ($enable_archive !== false) {
        /*
         * The first test determines whether an option has been saved.
         * The second test checks the value before acting.
         */
        if (!$enable_archive) {
            $args['rewrite'] = false;
        }
    }

    return $args;
}

/**
 * Removes association between custom taxonomies and post types based on plugin options.
 *
 * Called on action: `registered_taxonomy`
 *
 * @since 0.1.0
 *
 * @param string $taxonomy Taxonomy key.
 * @param array|string $object_type Name of the object type for the taxonomy object.
 * @return void
 */
function options_registered_taxonomy(string $taxonomy, $object_type) {
    $multi_obj_taxonomies = [
        College::TAXONOMY,
        Department::TAXONOMY
    ];

    if (!in_array($taxonomy, $multi_obj_taxonomies)) {
        return;
    }

    $tax = str_replace('pdl_', '', $taxonomy);
    $obj_type_option = Plugin::get_option($tax . '_object_type');

    if (is_array($obj_type_option)) {
        $diff = array_diff($object_type, $obj_type_option);
        if (!empty($diff)) {
            $post_types = Plugin::post_types();

            foreach($diff as $post_type) {
                if (in_array($post_type, $post_types)) {
                    unregister_taxonomy_for_object_type($taxonomy, $post_type);
                }
            }
        }
    }
}

/**
 * Updates the title for filtered results in archives and program subpages.
 *
 * Called on filter: `document_title_parts`
 *
 * @since 0.1.0
 *
 * @param array $title The current title parts.
 */
function document_title_parts(array $title): array {

    if (pdl_is_filtered_results(Plugin::post_types())) {
        $post_type = get_query_var('post_type');
        /**
         * Filters the format of the document title part of filtered post type archives.
         *
         * @param $format The format of the document title part.
         * @param $post_type The current post type.
         */
        $format = apply_filters(
            'pdl/filter_results_document_title_format',
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
            'pdl/filtered_results_document_title_label',
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

/**
 * Outputs CSS variables for user color preferences.
 *
 * Called on action: `wp_head`
 *
 * @since 0.1.0
 *
 * @return void
 */
function options_wp_head() {
    $style_tag = '<style>html body{%s}</style>';
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
        printf(
            $style_tag,
            implode(';', $vars)
        );
    }
}

/**
 * Adds body class name based on presentation mode.
 *
 * @since 0.1.0
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
 * Called on filter: `admin_body_class`
 *
 * @since 0.1.0
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
 * Called on filter: `post_class`
 *
 * @since 0.1.0
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
 * @since 0.1.0
 *
 * @param string $link The current term link.
 * @return string The modified term link.
 */
function term_link(string $link): string {
    $query_start = strpos($link, '?');

    if ($query_start !== false) {
        if (is_admin() && isset($_GET['post_type'])) {
            $post_type = $_GET['post_type'];
        } else {
            $post_type = get_query_var('post_type');
        }

        if (!in_array($post_type, ['post','page'], true)) {
            $link = get_post_type_archive_link($post_type) . substr($link, $query_start);
        }
    }

    return $link;
}

/**
 * Alters Program Type labels based on plugin options.
 *
 * Called on filter: `taxonomy_labels_pdl_program_type`
 *
 * @since 0.1.0
 *
 * @param object $labels The WP_Taxonomy labels property.
 * @return object The filtered labels.
 */
function options_program_type_labels($labels) {
    return options_taxonomy_labels($labels, ProgramType::TAXONOMY);
}

/**
 * Alters College labels based on plugin options.
 *
 * Called on filter: `taxonomy_labels_pdl_college`
 *
 * @since 0.1.0
 *
 * @param object $labels The WP_Taxonomy labels property.
 * @return object The filtered labels.
 */
function options_college_labels($labels) {
    return options_taxonomy_labels($labels, College::TAXONOMY);
}

/**
 * Alters Instruction Mode labels based on plugin options.
 *
 * Called on filter: `taxonomy_labels_pdl_instruct_mode`
 *
 * @since 0.1.0
 *
 * @param object $labels The WP_Taxonomy labels property.
 * @return object The filtered labels.
 */
function options_instruct_mode_labels($labels) {
    return options_taxonomy_labels($labels, InstructionMode::TAXONOMY);
}

/**
 * Alters Subject labels based on plugin options.
 *
 * Called on filter: `taxonomy_labels_pdl_subject`
 *
 * @since 0.1.0
 *
 * @param object $labels The WP_Taxonomy labels property.
 * @return object The filtered labels.
 */
function options_subject_labels($labels) {
    return options_taxonomy_labels($labels, Subject::TAXONOMY);
}

/**
 * Alters Session labels based on plugin options.
 *
 * Called on filter: `taxonomy_labels_pdl_session`
 *
 * @since 0.1.0
 *
 * @param object $labels The WP_Taxonomy labels property.
 * @return object The filtered labels.
 */
function options_session_labels($labels) {
    return options_taxonomy_labels($labels, Session::TAXONOMY);
}

/**
 * Alters Person Category labels based on plugin options.
 *
 * Called on filter: `taxonomy_labels_pdl_person_cat`
 *
 * @param object $labels The WP_Taxonomy labels property.
 * @return object The filtered labels.
 */
function options_person_cat_labels($labels) {
    return options_taxonomy_labels($labels, PersonCategory::TAXONOMY);
}

/**
 * Alters Department labels based on plugin options.
 *
 * Called on filter: `taxonomy_labels_pdl_department`
 *
 * @since 0.1.0
 *
 * @param object $labels The WP_Taxonomy labels property.
 * @return object The filtered labels.
 */
function options_department_labels($labels) {
    return options_taxonomy_labels($labels, Department::TAXONOMY);
}

/**
 * Alters FAQ Category labels based on plugin options.
 *
 * Called on filter: `taxonomy_labels_pdl_faq_cat`
 *
 * @since 0.1.0
 *
 * @param object $labels The WP_Taxonomy labels property.
 * @return object The filtered labels.
 */
function options_faq_cat_labels($labels) {
    return options_taxonomy_labels($labels, FAQCategory::TAXONOMY);
}

/**
 * Alters our custom taxonomy labels based on plugin options.
 *
 * @since 0.1.0
 *
 * @param object $labels The WP_Taxonomy labels property.
 * @param string $taxonomy The name of the current taxonomy
 * @return object The filtered labels.
 */
function options_taxonomy_labels($labels, $taxonomy) {
    $tax = str_replace('pdl_', '', $taxonomy);

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
 * Called on: `pdl/before_main_content`
 *
 * @since 0.1.0
 *
 * @return void
 */
function before_main_content() {
    $pattern = '<%s id="%s" class="%s">';
    $id = apply_filters('pdl/main_content_wrapper_id', 'main-content-wrapper');
    $classes = ['pdlcms', 'pdl-template'];
    $classes = apply_filters('pdl/careers/main_content_wrapper_class', $classes);
    $tag = Plugin::get_option('main_content_wrapper_tag');

    printf(
        $pattern,
        $tag,
        $id,
        esc_attr(implode(' ', $classes))
    );
}

/**
 * Action to output end tag of main content wrapper.
 *
 * Called on: `pdl/after_main_content`
 *
 * @since 0.1.0
 *
 * @return void
 */
function after_main_content() {
    $tag = Plugin::get_option('main_content_wrapper_tag');

    echo "</{$tag}>";
}

/**
 * Filters various template args based on plugin options.
 *
 * Called on filter: `pdl/template_args`
 *
 * @since 0.1.0
 *
 * @param array $args The current template args.
 * @param string $template The current template name.
 * @return string The modified template args.
 */
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

/**
 * Modifies template args for `common/filters` based on plugin options.
 *
 * @since 0.1.0
 *
 * @param array $args The current template args.
 * @return array The modified template args.
 */
function options_search_filters($args) {
    $post_type = str_replace('pdl_', '', get_query_var('post_type'));
    $enabled = Plugin::get_option($post_type . '_archive_search_filters');

    if (!is_array($enabled)) {
        return $args;
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

/**
 * Updates the post archive title based on plugin options.
 *
 * Called on filter: `post_type_archive_title`
 *
 * @since 0.1.0
 *
 * @param string $title The existing title.
 * @param string $post_type The current post type.
 * @return string The modified title.
 */
function options_post_type_archive_title($title, $post_type) {
    if (in_array($post_type, Plugin::post_types())) {
        $post_type = str_replace('pdl_', '', $post_type);
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
        $post_type = str_replace('pdl_', '', $post_type_obj->name);
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
 * Called on filter: `pdl/template_defaults`
 *
 * @since 0.1.0
 *
 * @param array $defaults The template defaults.
 * @param string $template The name of the template.
 * @return array The filtered defaults.
 */
function options_template_defaults($defaults, $template) {
    $post_type = get_query_var('post_type');
    $taxonomy = get_query_var('taxonomy');

    if (!in_array($post_type, Plugin::post_types()) && !in_array($taxonomy, Plugin::taxonomies())) {
        return $defaults;
    }

    $post_type = str_replace('pdl_', '', $post_type);
    $presentation_mode = Plugin::get_option('presentation_mode');

    switch($template) {
        case 'common/breadcrumbs':
            $defaults['show_breadcrumbs'] = Plugin::get_option('display_breadcrumbs');

            break;
        case 'common/page-header-backdrop':
            $defaults = options_page_header_backdrop($defaults, $post_type, $presentation_mode);

            break;
        case 'common/term-featured-image':
            $defaults = options_header_image_size($defaults);

            break;
        case 'common/post-type-featured-image':
            $defaults = options_header_image_size($defaults);
            $defaults['featured_img'] = Plugin::get_option($post_type . '_archive_featured_image');

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
        case 'single-course/related-personnel':
            $label = 'label_instructors';
            $value = Plugin::get_option('course_' . $label);

            if ($value) {
                $defaults[$label] = $value;
            }

            break;
        default:
            break;
    }

    return $defaults;
}

/**
 * Filters the template defaults for `common/post-featured-image` based on plugin options.
 *
 * @since 0.1.0
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
            $defaults = options_header_image_size($defaults);
        }
    }

    return $defaults;
}

/**
 * Modifies the template defaults for post type and taxonomy featured image templates.
 *
 * @since 0.1.0
 *
 * @param array $defaults The existing template defaults.
 * @return void The modified template defaults.
 */
function options_header_image_size($defaults) {
    $size = Plugin::get_option('image_size_header');

    if ($size) {
        $defaults['image_size'] = $size;

        if ($defaults['image_size'] === 'custom') {
            $defaults['image_size'] = [
                (int) Plugin::get_option('image_size_header_w'),
                (int) Plugin::get_option('image_size_header_h'),
            ];
        }
    }

    return $defaults;
}

/**
 * Modifies the template defaults for `common/page-header-backdrop`.
 *
 * @since 0.1.0
 *
 * @param array $defaults The current template defaults.
 * @param string $post_type The current post type.
 * @param string $presentation_mode The currently active presentation mode (either of 'none', 'base', 'full').
 * @return array The modified template defaults.
 */
function options_page_header_backdrop($defaults, $post_type, $presentation_mode) {
    if ($presentation_mode !== 'full') {
        return $defaults;
    }

    $defaults['show_backdrop'] = true;

    if (!$post_type) {
        $taxonomy = get_query_var('taxonomy');
        $term = get_term_by('slug', get_query_var('term'), $taxonomy);
        $img = get_field('header_background', $term);

        if ($img) {
            $defaults['attachment_id'] = $img;
        } else {
            $taxonomy = get_taxonomy($taxonomy);

            if (!empty($taxonomy->object_type)) {
                $post_type = str_replace('pdl_', '', $taxonomy->object_type[0]);
            }
        }
    }

    if ($post_type) {
        $defaults['attachment_id'] = Plugin::get_option($post_type . '_archive_header_background');
    }

    if (is_singular()) {
        $img = Plugin::get_option($post_type . '_header_background');

        if ($img) {
            $defaults['attachment_id'] = $img;
        } else if ($defaults['fallback_to_post']) {
            $img = Plugin::get_option($post_type . '_default_featured_image');

            if ($img) {
                $defaults['attachment_id'] = $img;
            }
        }
    }

    return $defaults;
}

/**
 * Sets the subpage labels based on plugin options.
 *
 * Called on filter: `pdl/add_subpage`
 *
 * @since 0.1.0
 *
 * @param Subpage $subpage The subpage being registered.
 * @param String $post_type The current post type.
 * @return Subpage The modified subpage object.
 */
function options_subpage_labels($subpage, $post_type) {
    $option_prefix = sprintf(
        '%s_subpage_%s_',
        str_replace('pdl_', '', $post_type),
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

/**
 * Modifies the args of action list templates for programs and courses.
 *
 * @since 0.1.0
 *
 * @param array $args The current template args.
 * @return array The modified template args.
 */
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

/**
 * Modifies registered plugin labels based on plugin options.
 *
 * Called on filter: `pdl/get_label`
 *
 * @since 0.1.0
 *
 * @param string $label The label being requested.
 * @param string $label_key The label identifier.
 * @param string $plugin The identifier of the current plugin (deprecated).
 * @return string The filtered label.
 */
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

/**
 * Modifies the defaults for the `single-program/contact` template.
 *
 * @since 0.1.0
 *
 * @param array $defaults The current template defaults.
 * @return array The filtered template defaults.
 */
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
