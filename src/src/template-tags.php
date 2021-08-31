<?php

function nvis_prog_get_template_part(string $template, array $data = []) {
    \InvisibleUs\Programs\TemplateManager::loadTemplate($template, $data);
}

function nvis_prog_is_filtered_results(): bool {
    return
    is_post_type_archive('nvis_program') &&
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
    return \InvisibleUs\Programs\get_subpages();
}

function nvis_prog_get_active_subpage(): string {
    return \InvisibleUs\Programs\get_active_subpage();
}

// TODO: Move this to subpages.
function nvis_prog_show_subpage(string $subpage): bool {
    return \InvisibleUs\Programs\maybe_show_subpage($subpage);
}

function nvis_prog_is_active_subpage(string $subpage): bool {
    return nvis_prog_get_active_subpage() === $subpage;
}

// TODO: Move this to subpages.
function nvis_prog_subpage_link(string $subpage, bool $echo = true): string {
    $link = $subpage === 'index' ?
    get_the_permalink() :
    sprintf('%s%s/', get_the_permalink(), $subpage);

    if ($echo) {
        echo $link;
    }

    return $link;
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

function nvis_prog_the_application_deadlines(mixed $program = null): array {
    return \InvisibleUs\Programs\get_program_application_deadlines($program);
}

function nvis_prog_get_related_posts(mixed $post = null, array $not_in): array {
    return \InvisibleUs\Programs\get_program_related_posts($post, $not_in);
}

function nvis_prog_get_faqs_by_category(array $faqs): array {
    return \InvisibleUs\Programs\group_faqs_by_category($faqs);
}
