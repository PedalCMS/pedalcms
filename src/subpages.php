<?php

namespace InvisibleUs\Programs;

add_action('wp', __NAMESPACE__ . '\maybe_override_rel_canonical');

add_filter('rewrite_rules_array', __NAMESPACE__ . '\insert_rules');
add_filter('query_vars', __NAMESPACE__ . '\insert_query_var');


function get_subpages(): array {
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

function maybe_show_subpage(string $subpage): bool {
    // TODO: Add Global Setting awareness.
    return $subpage === 'index' ?
        true :
        (bool) get_field(
            sprintf('show_%s_section', $subpage)
        );
}


// TODO: Make this configurable.
// Add rewrite rules for programs subpages.
function insert_rules($rules) {
    $subpages = nvis_prog_get_subpages();

    $subpage_rules = [];
    foreach ($subpages as $slug => $title) {
        // TODO: load program stub dynamically.
        $subpage_rules['program/([^/]+)/' . $slug . '/?$'] = 'index.php?nvis_program=$matches[1]&nvis_subpage=' . $slug;
    }

    return $subpage_rules + $rules;
}

// Tell WordPress to accept our custom query variable.
function insert_query_var($vars) {
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

function get_active_subpage(): string {
    $subpage = get_query_var('nvis_subpage');
    return $subpage ? $subpage : 'index';
}
