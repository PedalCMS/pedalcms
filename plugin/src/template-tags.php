<?php

/**
 * All template tags created by the plugin.
 * 
 * @version 0.1.0
 * @package NVISPrograms
 * @since 0.1.0
 */


function nvis_prog_get_template_part(string $template, array $data = []) {
    \InvisibleUs\Programs\TemplateManager::loadTemplate($template, $data);
}

function nvis_prog_is_filtered_results($post_type = null): bool {
    $post_type = $post_type ?? \InvisibleUs\Programs\Program::POST_TYPE;

    return
        is_post_type_archive($post_type) &&
        (is_search() || is_tax());
}

function nvis_prog_has_news(): bool {
    // TODO: Make this work.
    return false;
}

function nvis_prog_show_subpages(): bool {
    // TODO: Make this work.
    return true;
}

function nvis_prog_get_subpages(): array {
    return \InvisibleUs\Programs\ProgramSubpageManager::get_subpages();
}

function nvis_prog_get_active_subpage(): string {
    return \InvisibleUs\Programs\ProgramSubpageManager::get_active_subpage();
}

function nvis_prog_show_subpage(string $subpage): bool {
    return \InvisibleUs\Programs\ProgramSubpageManager::maybe_show_subpage($subpage);
}

function nvis_prog_is_active_subpage(string $subpage): bool {
    return \InvisibleUs\Programs\ProgramSubpageManager::is_active_subpage($subpage);
}

function nvis_prog_subpage_link(string $subpage, bool $echo = true): string {
    return \InvisibleUs\Programs\ProgramSubpageManager::get_subpage_link($subpage, $echo);
}

function nvis_prog_get_action_link(string $action, mixed $program = null): string {
    $program = get_post($program);

    // Check for a local override.
    $url = get_field('url_' . $action, $program);

    if ($url) {
        return $url;
    }

    // Check for the global setting.
    $url = get_field('nvis_url_' . $action, 'option');

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

function nvis_prog_get_course_action_link(string $action, $course): string {
    $course = get_post($course);

    // Check for a local override.
    $url = get_field('url_' . $action, $course);

    if ($url) {
        return $url;
    }

    // Check for the global setting.
    $url = get_field('nvis_course_url_' . $action, 'option');

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

function nvis_prog_the_application_deadlines(mixed $program = null): array {
    return \InvisibleUs\Programs\Program::get_application_deadlines($program);
}

function nvis_prog_get_related_posts(mixed $post = null, array $not_in): array {
    return \InvisibleUs\Programs\Program::get_related_posts($post, $not_in);
}

function nvis_prog_get_faqs_by_category(array $faqs): array {
    return \InvisibleUs\Programs\FAQ::group_by_category($faqs);
}

function nvis_prog_get_people_by_category(array $people): array {
    return \InvisibleUs\Programs\Person::group_by_category($people);
}
