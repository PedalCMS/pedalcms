<?php
/**
 * Template tags specifically for this plugin.
 *
 * @package NVISPrograms
 * @since 0.1.0
 */

/**
 * Outputs a template.
 *
 * Alias of TemplateManager::load_template()
 *
 * @param string $template The requested template file. Can include subdir.
 * @param array $data Data to pass to the requested template.
 * @return void
 */
function nvis_prog_get_template_part(string $template, array $data = []) {
    \InvisibleUs\Programs\TemplateManager::load_template($template, $data);
}

function nvis_prog_get_label(string $label): string {
    return \InvisibleUs\Programs\Plugin::get_label($label);
}

function nvis_prog_register_program_subpage(string $slug, array $args = []) {
    $args['builtin'] = false;
    $subpage = new \InvisibleUs\Programs\Subpage($slug, $args);

    return \InvisibleUs\Programs\Program::subpage_manager()->add_subpage($subpage);
}

/**
 * Determines whether or not to display Program subpages.
 *
 * @return bool
 */
function nvis_prog_show_subpages(): bool {
    // TODO: Make this work.
    return true;
}

/**
 * Returns the registered list of Program subpages.
 *
 * Alias of SubpageManager::get_subpages()
 *
 * @param bool $with_index Whether or not to include the index.
 * @param string $return_type Can be 'hash' or 'objects'.
 * @return array List of subpages
 */
function nvis_prog_get_subpages(bool $with_index = true, string $return_type = 'objects'): array {
    return \InvisibleUs\Programs\Program::subpage_manager()->get_subpages($with_index, $return_type);
}

/**
 * Returns the active subpage by slug.
 *
 * Alias of SubpageManager::get_active_subpage(). Should only be called
 * in the context of a single program.
 *
 * @param string $return_type The format of the returned subpage. Either 'slug' or 'object'.
 * @return mixed The active subpage, either slug or the full object. False if active page not found.
 */
function nvis_prog_get_active_subpage(string $return_type = 'slug') {
    return \InvisibleUs\Programs\Program::subpage_manager()->get_active_subpage($return_type);
}

/**
 * Determines whether a particular subpage should be rendered.
 *
 * Alias of SubpageManager::maybe_show_subpage().
 *
 * @param mixed $subpage Either a InvisibleUs\Programs\Subpage or the slug of one.
 * @return boolean
 */
function nvis_prog_show_subpage($subpage): bool {
    return \InvisibleUs\Programs\Program::subpage_manager()->maybe_show_subpage($subpage);
}

/**
 * Tests whether the subpage is currently active.
 *
 * Alias of ProgramSubpageManager::is_active_subpage()
 *
 * @param string $subpage The slug of the page to test.
 * @return boolean
 */
function nvis_prog_is_active_subpage(string $subpage): bool {
    return \InvisibleUs\Programs\Program::subpage_manager()->is_active_subpage($subpage);
}

/**
 * Generates a URL for a given subpage.
 *
 * Alias of ProgramSubpageManager::get_subpage_link(). Should only be called
 * in the context of a single program.
 *
 * @param string $subpage The slug of the subpage.
 * @param boolean $echo Whether or not to output the URL.
 * @return string The subpage URL.
 */
function nvis_prog_subpage_link(string $subpage, bool $echo = true): string {
    return \InvisibleUs\Programs\Program::subpage_manager()->get_subpage_link($subpage, $echo);
}

/**
 * Generates the CSS class names for a subpage container.
 *
 * @return array The list of class names.
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

function nvis_subpage_class() {
    echo sprintf(
        'class="%s"',
        esc_attr(implode(' ', nvis_get_subpage_class()))
    );
}



/**
 * Returns the full URL for a given program action.
 *
 * Will check for a local program override before attempting to build it from
 * the plugin wide pattern setting.
 *
 * @param string $action The name of the action.
 * @param mixed $program The ID of the program or a Post object.
 * @return string The URL of the program action.
 */
function nvis_prog_get_action_link(string $action, $program = null): string {
    // TODO: Move this to Plugin class.
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

/**
 * Returns the full URL for a given course action.
 *
 * Will check for a local course override before attempting to build it from
 * the plugin wide pattern setting.
 *
 * @param string $action The name of the action.
 * @param mixed $program The ID of the course or a Post object.
 * @return string The URL of the course action.
 */
function nvis_prog_get_course_action_link(string $action, $course): string {
    // TODO: Get rid of this function?
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

/**
 * Gets a list of application deadlines based on override hierarchy.
 *
 * Alias of Program::get_application_deadlines(). Hierarchy is Program,
 * College, Program Type, Global.
 *
 * @param mixed $program Program to check for news posts. Either ID or WP_Post.
 * @return array An ACF repeater field with deadline_label and deadline_info subfields.
 */
function nvis_prog_the_application_deadlines($program = null): array {
    return \InvisibleUs\Programs\Program::get_application_deadlines($program);
}

/**
 * Get the news posts for a given program by related tag.
 *
 * Alias of Program::get_related_posts(). Meta field news_tag must be set first.
 *
 * @param mixed $program Program to check for news posts. Either ID or WP_Post.
 * @param array $not_in List of ids to exclude from the results.
 * @return array List of WP_Posts that match the Program's tag.
 */
function nvis_prog_get_related_posts($post = null, array $not_in): array {
    return \InvisibleUs\Programs\Program::get_related_posts($post, $not_in);
}

/**
 * Takes a list of FAQs and returns them indexed by category.
 *
 * Alias of FAQ::group_by_category()
 *
 * @param array $faqs A list of FAQs of the type WP_Post.
 * @return array The category indexed list of FAQs.
 */
function nvis_prog_get_faqs_by_category(array $faqs): array {
    return \InvisibleUs\Programs\FAQ::group_by_category($faqs);
}

/**
 * Normalizes a list of FAQs of mixed type.
 *
 * Alias of FAQ::normalize_faq_types()
 *
 * @param array $faqs A list of FAQs of mixed type WP_Post.
 * @param bool $group_by_cat Group by FAQCategory?
 * @return array The list of FAQs, either grouped by category or not.
 */
function normalize_faq_types(array $faqs, bool $group_by_cat = false): array {
    return \InvisibleUs\Programs\FAQ::normalize_faq_types($faqs, $group_by_cat);
}


/**
 * Takes a list of People and returns them indexed by category.
 *
 * Alias of Person::group_by_category()
 *
 * @param array $people A list of People of the type WP_Post.
 * @return array The category indexed list of people.
 */
function nvis_prog_get_people_by_category(array $people): array {
    return \InvisibleUs\Programs\Person::group_by_category($people);
}

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
