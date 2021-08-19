<?php

namespace InvisibleUs\Programs;
// TODO: Namespace this file. 

add_action('wp', __NAMESPACE__ . '\maybe_override_rel_canonical');

add_filter('rewrite_rules_array', __NAMESPACE__ . '\insert_rules');
add_filter('query_vars', __NAMESPACE__ . '\insert_query_var');

// Breadcrumb NavXT support.
add_action('bcn_before_fill', __NAMESPACE__ . '\navxt_add_subpage');
add_filter('bcn_breadcrumb_linked', __NAMESPACE__ . '\navxt_breadcrumb_linked', 10, 3);

// Yoast SEO Breadcrumb support.
add_filter('wpseo_breadcrumb_links', __NAMESPACE__ . '\yoast_add_subpage');

// All in One SEO Breadcrumb support.
add_filter('aioseo_breadcrumbs_trail', __NAMESPACE__ . '\aioseo_add_subpage');


function get_subpages(): array
{
    return [
        'index' => 'Overview',
        'careers' => 'Careers',
        'courses' => 'Courses',
        'faqs' => 'FAQs',
        'cost' => 'Cost',
        'apply' => 'How to Apply',
        'news' => 'News'
    ];
}

function maybe_show_subpage(string $subpage): bool
{
    // TODO: Add Global Setting awareness.
    return $subpage === 'index' ?
        true :
        (bool) get_field(
            sprintf('show_%s_section', $subpage)
        );
}


// TODO: Make this configurable.
// Add rewrite rules for programs subpages.
function insert_rules($rules)
{
    $subpages = nvis_prog_get_subpages();

    $subpage_rules = array();
    foreach ($subpages as $slug => $title) {
        // TODO: load program stub dynamically. 
        $subpage_rules['program/([^/]+)/' . $slug . '/?$'] = 'index.php?nvis_program=$matches[1]&nvis_subpage=' . $slug;
    }

    return $subpage_rules + $rules;
}

// Tell WordPress to accept our custom query variable.
function insert_query_var($vars)
{
    $vars[] = 'nvis_subpage';
    return $vars;
}

function maybe_override_rel_canonical() {
    if (is_singular('nvis_program') && nvis_prog_get_active_subpage() !== 'index') {
        remove_filter('wp_head', 'rel_canonical');
        add_filter('wp_head', __NAMESPACE__  . '\subpage_canonical');
    }
}

// Custom canonical link for Program subpages.
function subpage_canonical() {
    echo sprintf(
        '<link rel="canonical" href="%s" />', 
        nvis_prog_subpage_link(nvis_prog_get_active_subpage(), false)
    );
}

function get_active_subpage(): string
{
    $subpage = get_query_var('nvis_subpage');
    return $subpage ? $subpage : 'index';
}

function navxt_add_subpage(object $breadcrumb_trail)
{
    if (is_singular('nvis_program')) {
        $subpage = nvis_prog_get_active_subpage();
        $title = (nvis_prog_get_subpages())[$subpage];
        // TODO: Add support for "Link Current Item" feature.
        $breadcrumb_trail->add(new \bcn_breadcrumb($title, null, [], null, null, false));
    }
}

function navxt_breadcrumb_linked(bool $linked, array $types, int $id = null): bool
{
    if (is_singular('nvis_program') && in_array('post-nvis_program', $types)) {
        // TODO: Add support for "Link Current Item" feature.
        // ID is null for newly created subpages.
        return (bool) $id;
    }
    return $linked;
}

function yoast_add_subpage(array $crumbs): array {
    global $post;

    if (is_singular('nvis_program')) {
        $subpage = nvis_prog_get_active_subpage();
        $title = (nvis_prog_get_subpages())[$subpage];

        $crumbs[] = [
            'text' => $title,
            'url' => nvis_prog_subpage_link($subpage, false),
        ];
    }

    return $crumbs;
}

function aioseo_add_subpage(array $crumbs): array
{
    global $post;

    if (is_singular('nvis_program')) {
        $subpage = nvis_prog_get_active_subpage();
        $title = (nvis_prog_get_subpages())[$subpage];
        // error_log(print_r($crumbs, true));
        $crumbs[] = [
            'label' => $title,
            'link' => nvis_prog_subpage_link($subpage, false),
        ];
    }

    return $crumbs;
}
