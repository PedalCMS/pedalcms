<?php
/**
 * Breadcrumb adapter functions for NavXT, YoastSEO, and All in One SEO.
 *
 * @package NVISPrograms
 * @since 0.1.0
 */

namespace InvisibleUs\Programs;

// Breadcrumb NavXT support.
add_action('bcn_before_fill', __NAMESPACE__ . '\navxt_add_subpage');
add_action('bcn_after_fill', __NAMESPACE__ . '\navxt_replace_archive_trail');
add_filter('bcn_breadcrumb_linked', __NAMESPACE__ . '\navxt_breadcrumb_linked', 10, 3);

// Yoast SEO Breadcrumb support.
add_filter('wpseo_breadcrumb_links', __NAMESPACE__ . '\yoast_update_trail');

// All in One SEO Breadcrumb support.
add_filter('aioseo_breadcrumbs_trail', __NAMESPACE__ . '\aioseo_update_trail');

/**
 * Generates a crumb based on the current archive.
 *
 * @return array Associative array with 'text' and 'url' keys.
 */
function get_archive_crumb(): array {
    $found = false;

    $post_types = [
        // TODO: Add these to the objects and reference them.
        Program::POST_TYPE => 'Programs',
        Person::POST_TYPE  => 'Directory',
    ];

    foreach ($post_types as $post_type => $text) {
        if (is_post_type_archive($post_type)) {
            $found = true;

            break;
        }
    }

    if ($found) {
        // TODO: Make this filterable.
        return [
            'text' => $text,
            'url'  => get_post_type_archive_link($post_type)
        ];
    }

    return [];
}

/**
 * Generates a crumb based on the current Program subpage.
 *
 * @return array Associative array with 'text' and 'url' keys.
 */
function get_program_subpage_crumb(): array {
    $subpage = nvis_prog_get_active_subpage();

    return [
        'text' => (nvis_prog_get_subpages())[$subpage],
        'url'  => nvis_prog_subpage_link($subpage, false)
    ];
}

/**
 * Adds a crumb for the current program subpage to NavXT.
 *
 * Called on action: bcn_before_fill
 *
 * @param object $trail The current breadcrumb trail.
 */
function navxt_add_subpage(object $trail): void {
    if (is_singular(Program::POST_TYPE)) {
        $crumb = get_program_subpage_crumb();
        $linked = (bool) $trail->opt['bcurrent_item_linked'];
        $trail->add(new \bcn_breadcrumb($crumb['text'], null, [], $crumb['url'], null, $linked));
    }

    return;
}

/**
 * Rebuilds the entire trail for archives when using Breadcrumb NavXT.
 *
 * Called on action: bcn_after_fill
 *
 * @param object $trail The current breadcrumb trail.
 * @return void
 */
function navxt_replace_archive_trail(object $trail) {
    $post_types = [Program::POST_TYPE, Person::POST_TYPE];

    if (nvis_prog_is_filtered_results($post_types)) {
        if ($trail->opt['bhome_display']) {
            $home = array_pop($trail->breadcrumbs);
        }
        $trail->breadcrumbs = [];
        $crumb = get_archive_crumb();

        $trail->add(new \bcn_breadcrumb('Filtered Results', null, [], null, null, false));
        $trail->add(new \bcn_breadcrumb($crumb['text'], null, [], $crumb['url'], null, true));

        if ($trail->opt['bhome_display']) {
            $trail->breadcrumbs[] = $home;
        }
    }
}

/**
 * Determines whether or not to link the breadcrumb in single post type situations.
 *
 * Called on filter: bcn_breadcrumb_linked
 *
 * @param bool $linked The current value of this filtered variable.
 * @param array $types The types of the crumb being evaluated.
 * @param int $id The ID of the object related to the crumb being evalualted.
 * @return bool Whether or not the crumb should be linked.
 */
function navxt_breadcrumb_linked(bool $linked, array $types, int $id = null): bool {
    // TODO: Double-check that this shouldn't be only for Program Subpages.
    $post_types = [Program::POST_TYPE, Person::POST_TYPE];

    // TODO: Add support for "Link Current Item" feature.
    foreach ($post_types as $post_type) {
        if (is_singular($post_type) && in_array('post-' . $post_type, $types, true)) {
            // ID is null for newly created subpages.
            return (bool) $id;
        }
    }

    return $linked;
}

/**
 * Updates the Yoast trail for program subpages and filtered results.
 *
 * Called on filter: wpseo_breadcrumb_links
 *
 * @param array $crumbs The current trail of crumbs.
 * @return array The filtered trail of crumbs.
 */
function yoast_update_trail(array $crumbs): array {
    if (is_singular(Program::POST_TYPE)) {
        return yoast_add_subpage($crumbs);
    }

    $post_types = [Program::POST_TYPE, Person::POST_TYPE];
    // FIXME: Passing an array i/o a string.
    if (nvis_prog_is_filtered_results($post_types)) {
        return yoast_replace_trail($crumbs);
    }

    return $crumbs;
}

/**
 * Adds the current subpage crumb to the Yoast trail.
 *
 * @param array $crumbs The current trail of crumbs.
 * @return array The filtered trail of crumbs.
 */
function yoast_add_subpage(array $crumbs): array {
    $crumbs[] = get_program_subpage_crumb();

    return $crumbs;
}

/**
 * Rebuild the entire Yoast trail for the current archive.
 *
 * @param array $crumbs The current trail of crumbs.
 * @return array The new trail of crumbs.
 */
function yoast_replace_trail(array $crumbs): array {
    $home = array_shift($crumbs);

    return [
        $home,
        get_archive_crumb(),
        // TODO: Make text filterable.
        ['text' => 'Filtered Results', 'url' => null]
    ];
}

/**
 * Updates the AiOSEO trail for program subpages and filtered results.
 *
 * Called on filter: aioseo_breadcrumbs_trail
 *
 * @param array $crumbs The current trail of crumbs.
 * @return array The filtered trail of crumbs.
 */
function aioseo_update_trail(array $crumbs): array {
    if (is_singular(Program::POST_TYPE)) {
        return aioseo_add_subpage($crumbs);
    }

    $post_types = [Program::POST_TYPE, Person::POST_TYPE];

    if (nvis_prog_is_filtered_results($post_types)) {
        return aioseo_replace_trail($crumbs);
    }

    return $crumbs;
}

/**
 * Adds the current subpage crumb to the AiOSEO trail.
 *
 * @param array $crumbs The current trail of crumbs.
 * @return array The filtered trail of crumbs.
 */
function aioseo_add_subpage(array $crumbs): array {
    $crumb = get_program_subpage_crumb();
    $crumbs[] = [
        'label' => $crumb['text'],
        'link'  => $crumb['url'],
    ];

    return $crumbs;
}

/**
 * Rebuild the entire AiOSEO trail for the current archive.
 *
 * @param array $crumbs The current trail of crumbs.
 * @return array The new trail of crumbs.
 */
function aioseo_replace_trail(array $crumbs): array {
    $crumbs = [];
    $home = aioseo()->breadcrumbs->maybeGetHomePageCrumb();

    if ($home) {
        $crumbs[] = $home;
    }

    $crumbs[] = aioseo()->breadcrumbs->getPostTypeArchiveCrumb(get_queried_object());
    // TODO: Make label filterable.
    $crumbs[] = ['label' => 'Filtered Results', 'link' => 'null'];

    return $crumbs;
}
