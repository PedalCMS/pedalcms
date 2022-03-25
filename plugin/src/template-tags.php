<?php
/**
 * Template tags specifically for this plugin.
 *
 * @package NVISPrograms
 * @since 0.1.0
 */

if (!function_exists('nvis_prog_get_template_part')) :
/**
 * Outputs a template.
 *
 * Alias of TemplateManager::load_template()
 * 
 * @since 0.1.0
 * @see TemplateManager::load_template
 *
 * @param string $template The requested template file. Can include subdir.
 * @param array $data Data to pass to the requested template.
 * @return void
 */
function nvis_prog_get_template_part(string $template, array $data = []) {
    \InvisibleUs\Programs\TemplateManager::load_template($template, $data);
}

endif;

if (!function_exists('nvis_prog_get_label')) :
/**
 * Alias of {@see InvisibleUs\Programs\Plugin::get_label()}.
 * 
 * @since 0.1.0
 *
 * @param string $label The machine name of the label.
 * @return string The human readable version of label.
 */
function nvis_prog_get_label(string $label): string {
    return \InvisibleUs\Programs\Plugin::get_label($label);
}

endif;


if (!function_exists('nvis_prog_register_program_subpage')) :
/**
 * Registers a new program subpage. 
 * 
 * You must also provide a template to render the subpage. It should be located 
 * here:
 * {$theme-name}/nvis-program-pages/single-program/subpages/{$slug}.php
 * 
 * By default, all registered subpages are enabled for all programs. It is up
 * to you to handle cases where these should be displayed on a program by 
 * program basis. See filter {@see 'nvis/programs/maybe_show_subpage'}. 
 * 
 * @since 0.1.0
 * 
 * @param string $slug The URL slug of the new {@see \InvisibleUs\Programs\Subpage}.
 * @param array $args Array of args for registering a subpage. See {@see \InvisibleUs\Programs\Subpage::_constructor()} for list.
 * @return mixed The Subpage object on success. WP_Error on failure.
 */
function nvis_prog_register_program_subpage(string $slug, array $args = []) {
    // TODO: Consider moving this out of template tags.
    $args['builtin'] = false;
    $subpage = new \InvisibleUs\Programs\Subpage($slug, $args);

    return \InvisibleUs\Programs\Program::subpage_manager()->add_subpage($subpage);
}

endif;


if (!function_exists('nvis_prog_show_subpages')) :
/**
 * Determines whether or not to display Program subpages.
 * 
 * @since 0.1.0
 *
 * @return bool
 */
function nvis_prog_show_subpages(): bool {
    return count(
        \InvisibleUs\Programs\Program::subpage_manager()->get_subpages()
    );
}

endif;


if (!function_exists('nvis_prog_get_subpages')) :
/**
 * Returns the registered list of Program subpages.
 *
 * Alias of {@see \InvisibleUs\Programs\SubpageManager::get_subpages()}
 * 
 * @since 0.1.0
 *
 * @param bool $with_index Whether or not to include the index. Defaults to true.
 * @param string $return_type Can be 'hash' or 'objects'. Defaults to 'objects'.
 * @return array List of subpages
 */
function nvis_prog_get_subpages(bool $with_index = true, string $return_type = 'objects'): array {
    return \InvisibleUs\Programs\Program::subpage_manager()->get_subpages($with_index, $return_type);
}

endif;


if (!function_exists('nvis_prog_get_active_subpage')) :
/**
 * Returns the active subpage by slug.
 *
 * Alias of {@see \InvisibleUs\Programs\SubpageManager::get_active_subpage()}. Should only be called
 * in the context of a single program.
 * 
 * @since 0.1.0
 *
 * @param string $return_type The format of the returned subpage. Either 'slug' or 'object'. Defaults to 'slug'.
 * @return mixed The active subpage, either slug or the full object. False if active page not found.
 */
function nvis_prog_get_active_subpage(string $return_type = 'slug') {
    return \InvisibleUs\Programs\Program::subpage_manager()->get_active_subpage($return_type);
}

endif;


if (!function_exists('nvis_prog_show_subpage')) :
/**
 * Determines whether a particular subpage should be rendered.
 *
 * Alias of {@see \InvisibleUs\Programs\SubpageManager::maybe_show_subpage()}.
 * 
 * @since 0.1.0
 *
 * @param mixed $subpage Either a {@see InvisibleUs\Programs\Subpage} or the slug of one.
 * @return boolean
 */
function nvis_prog_show_subpage($subpage): bool {
    return \InvisibleUs\Programs\Program::subpage_manager()->maybe_show_subpage($subpage);
}

endif;


if (!function_exists('nvis_prog_is_active_subpage')) :
/**
 * Tests whether a subpage is currently active.
 *
 * Alias of {@see InvisibleUs\Programs\SubpageManager::is_active_subpage()}
 * 
 * @since 0.1.0
 *
 * @param string $subpage The slug of the subpage to test.
 * @return boolean
 */
function nvis_prog_is_active_subpage(string $subpage): bool {
    return \InvisibleUs\Programs\Program::subpage_manager()->is_active_subpage($subpage);
}

endif;


if (!function_exists('nvis_prog_subpage_title')) : 
/**
 * Gets the content current subpage content title.
 *
 * @return string The current subpage title.
 */
function nvis_prog_subpage_title(): string {
    $subpage = nvis_prog_get_active_subpage('object');

    if (is_wp_error($subpage)) {
        return $subpage->get_error_message();
    }

    return $subpage->title;
}

endif; 


if (!function_exists('nvis_prog_subpage_link')) :
/**
 * Generates a URL for a given subpage.
 *
 * Alias of {@see InvisibleUs\Programs\SubpageManager::get_subpage_link()}. Should only be called
 * in the context of a single program.
 * 
 * @since 0.1.0
 *
 * @param string $subpage The slug of the subpage.
 * @param boolean $echo Whether or not to output the URL. Defaults to true.
 * @return string The subpage URL.
 */
function nvis_prog_subpage_link(string $subpage, bool $echo = true): string {
    return \InvisibleUs\Programs\Program::subpage_manager()->get_subpage_link($subpage, $echo);
}

endif;


if (!function_exists('nvis_get_subpage_class')) :
/**
 * Generates the CSS class names for a subpage container.
 * 
 * @since 0.1.0
 *
 * @return array The list of class name strings.
 */
function nvis_get_subpage_class(): array {
    $active = \InvisibleUs\Programs\Program::subpage_manager()->get_active_subpage();

    $classes = [
        'program-subpage-' . $active,
        'program-subpage',
    ];

    /**
     * Filters the list of CSS class names for the current post.
     *
     * @since 0.1
     *
     * @param string[] $classes An array of class names.
     * @param string[] $subpage The slug of the current subpage.
     */
    $classes = apply_filters('nvis/programs/subpage_class', $classes, $active);

    return array_unique($classes);
}

endif; 


if (!function_exists('nvis_subpage_class')) :
/**
 * Outputs the current subpage class with the class attribute string.
 * 
 * @since 0.1.0
 *
 * @see nvis_get_subpage_class()
 * @return void
 */
function nvis_subpage_class() {
    echo sprintf(
        'class="%s"',
        esc_attr(implode(' ', nvis_get_subpage_class()))
    );
}

endif;


if (!function_exists('nvis_prog_get_action_link')) :
/**
 * Returns the full URL for a given program action.
 *
 * Will check for a local program override before attempting to build it from
 * the plugin wide pattern setting.
 * 
 * @since 0.1.0
 *
 * @param string $action The name of the action.
 * @param mixed $program The ID of the program or a WP_Post object. Defaults to the current program.
 * @return string The URL of the program action.
 */
function nvis_prog_get_action_link(string $action, $program = null): string {
    // TODO: Move this to Program class?
    $program = get_post($program);

    // Check for a local override.
    $url = get_field('url_' . $action, $program);

    if ($url) {
        return $url;
    }

    $url = \InvisibleUs\Programs\Plugin::get_option('url_' . $action);

    if ($url) {
        $url = str_replace(
            ['{$program_guid}', '{$program_slug}'],
            [get_field('program_guid', $program), $program->post_name],
            $url
        );

        return $url;
    }

    return '';
}

endif;


if (!function_exists('nvis_prog_get_course_action_link')) :
/**
 * Returns the full URL for a given course action.
 *
 * Will check for a local course override before attempting to build it from
 * the plugin wide pattern setting.
 * 
 * @since 0.1.0
 *
 * @param string $action The name of the action.
 * @param mixed $program The ID of the course or a WP_Post object. Defaults to the current course.
 * @return string The URL of the course action.
 */
function nvis_prog_get_course_action_link(string $action, $course = null): string {
    // TODO: Move this to Course class?
    $course = get_post($course);

    $url = get_field('url_' . $action, $course);

    if ($url) {
        return $url;
    }

    $url = \InvisibleUs\Programs\Plugin::get_option('course_url_' . $action);

    if ($url) {
        $url = str_replace(
            [
                '{$course_cat_key}',
                '{$course_reg_key}'
            ],
            [
                get_field('course_catalog_key', $course),
                get_field('course_registration_key', $course)
            ],
            $url
        );

        return $url;
    }

    return '';
}

endif;


if (!function_exists('nvis_prog_the_application_deadlines')) :
/**
 * Gets a list of application deadlines based on override hierarchy.
 *
 * Alias of {@see InvisibleUs\Programs\Program::get_application_deadlines()}. 
 * Hierarchy is Program, College, Program Type, Global.
 * 
 * @since 0.1.0
 *
 * @param mixed $program Program to check for news posts. Either ID or WP_Post. Defaults to the current program.
 * @return array An ACF repeater field with deadline_label and deadline_info subfields.
 */
function nvis_prog_the_application_deadlines($program = null): array {
    return \InvisibleUs\Programs\Program::get_application_deadlines($program);
}

endif;


if (!function_exists('nvis_prog_get_related_posts')) :
/**
 * Get the news posts for a given program by related tag.
 *
 * Alias of {@see InvisibleUs\Programs\Program::get_related_posts()}. Meta 
 * field news_tag must be set first.
 * 
 * @since 0.1.0
 *
 * @param mixed $program Program to check for news posts. Either ID or WP_Post. Defaults to current program.
 * @param array $not_in List of ids to exclude from the results. Deafults to empty array.
 * @return array List of WP_Posts that match the Program's tag.
 */
function nvis_prog_get_related_posts($post = null, array $not_in = []): array {
    return \InvisibleUs\Programs\Program::get_related_posts($post, $not_in);
}

endif;


if (!function_exists('nvis_prog_get_faqs_by_category')) :
/**
 * Takes a list of FAQs and returns them indexed by category.
 *
 * Alias of {@see InvisibleUs\Programs\FAQ::group_by_category()}.
 * 
 * @since 0.1.0
 *
 * @param array $faqs A list of FAQs of the type WP_Post.
 * @return array The category indexed list of FAQs.
 */
function nvis_prog_get_faqs_by_category(array $faqs): array {
    return \InvisibleUs\Programs\FAQ::group_by_category($faqs);
}

endif;


if (!function_exists('normalize_faq_types')) :
/**
 * Normalizes a list of FAQs of mixed type.
 *
 * Alias of {@see InvisibleUs\Programs\FAQ::normalize_faq_types()}.
 * 
 * @since 0.1.0
 *
 * @param array $faqs A list of FAQs of mixed type WP_Post.
 * @param bool $group_by_cat Whether to group by {@see InvisibleUs\Programs\FAQCategory}. Defaults to false.
 * @return array The list of FAQs, either grouped by category or not.
 */
function normalize_faq_types(array $faqs, bool $group_by_cat = false): array {
    return \InvisibleUs\Programs\FAQ::normalize_faq_types($faqs, $group_by_cat);
}

endif;


if (!function_exists('nvis_prog_get_people_by_category')) :
/**
 * Takes a list of People and returns them indexed by category.
 *
 * Alias of {@see InvisibleUs\Programs\Person::group_by_category()}.
 * 
 * @since 0.1.0
 *
 * @param array $people A list of personnel of the type WP_Post.
 * @return array The category indexed list of people.
 */
function nvis_prog_get_people_by_category(array $people): array {
    return \InvisibleUs\Programs\Person::group_by_category($people);
}

endif;


if (!function_exists('nvis_prog_get_full_course_title')) :
/**
 * Prefixes the course title with the course code. 
 * 
 * @since 0.1.0
 *
 * @param mixed $post Either the ID of a post or a WP_Post object. Deafults to the current course.
 * @return void
 */
function nvis_prog_get_full_course_title($post = null) {
    $post = get_post($post);
    $title = '';

    if ($post->course_code) {
        $title .= sprintf(
            '<span class="course-code">%s</span> <span class="separator">&ndash;</span>',
            esc_html($post->course_code)
        );
    }

    $title .= sprintf(
        '<span class="course-name">%s</span>',
        esc_html($post->post_title)
    );

    return $title;
}

endif;
