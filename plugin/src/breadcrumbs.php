<?php
/**
 * Breadcrumb adapter functions for supported third-party breadcrumb generators. 
 * 
 * Currently, that list includes:
 * - Breadcrumb NavXT
 * - YoastSEO
 * - All in One SEO
 * - Rank Math
 *
 * @package NVISPrograms
 * @since 0.1.0
 */

namespace PedalCMS\Core;

// Breadcrumb NavXT support.
add_action('bcn_before_fill', __NAMESPACE__ . '\navxt_add_subpage');
add_action('bcn_after_fill', __NAMESPACE__ . '\navxt_replace_archive_trail');
add_filter('bcn_breadcrumb_linked', __NAMESPACE__ . '\navxt_breadcrumb_linked', 10, 3);

// Yoast SEO Breadcrumb support.
add_filter('wpseo_breadcrumb_links', __NAMESPACE__ . '\yoast_update_trail');

// All in One SEO Breadcrumb support.
add_filter('aioseo_breadcrumbs_trail', __NAMESPACE__ . '\aioseo_update_trail');

// Rank Math Support.
add_filter('rank_math/frontend/breadcrumb/items', __NAMESPACE__ . '\rankmath_update_trail', 10, 2);



/**
 * Generates a crumb based on the current archive.
 *
 * @return array Associative array with 'text' and 'url' keys.
 */
function get_archive_crumb(): array {
    $found = false;

    foreach (Plugin::post_types() as $post_type) {
        if (is_post_type_archive($post_type)) {
            $found = true;

            break;
        }
    }

    if ($found) {
        return [
            'text' => pdl_get_post_type_label($post_type, 'breadcrumb_label') ?? post_type_archive_title('', false),
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
    $subpage = pdl_get_active_subpage('object');

    return [
        'text' => $subpage->breadcrumb_label,
        'url'  => pdl_subpage_link($subpage->slug, false)
    ];
}

/**
 * Gets the breadcrumb label that is indicates that post type archive is filtered. 
 *
 * @return string The breadcrumb label.
 */
function get_filtered_results_breadcrumb_label(): string {
    /**
     * Filters the breadcrumb label that is indicates that post type archive is filtered. 
     * 
     * @since 0.1
     * 
     * @param $label The breadcrumb label. 
     */
     return apply_filters('pdl/filtered_results_breadcrumb_label', Plugin::get_label('filtered_results'));
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
    if (pdl_is_filtered_results(Plugin::post_types())) {
        if ($trail->opt['bhome_display']) {
            $home = array_pop($trail->breadcrumbs);
        }
        $trail->breadcrumbs = [];
        $crumb = get_archive_crumb();

        $label = get_filtered_results_breadcrumb_label();
        $trail->add(new \bcn_breadcrumb($label, null, [], null, null, false));
        $trail->add(new \bcn_breadcrumb($crumb['text'], null, [], $crumb['url'], null, true));

        if ($trail->opt['bhome_display']) {
            $trail->breadcrumbs[] = $home;
        }
    }
}

/**
 * Fixes the unlinked Program crumb when "Link Current Item" is off.
 *
 * The logic of this function relies on the $id argument being null for
 * Program subpages. It is a slightly brittle approach that stems from
 * Breadcrumb NavXT not understanding our Program subpages.
 *
 * Called on filter: bcn_breadcrumb_linked.
 *
 * @param bool $linked The current value of this filtered variable.
 * @param array $types The types of the crumb being evaluated.
 * @param int $id The ID of the object related to the crumb being evalualted.
 * @return bool Whether or not the crumb should be linked.
 */
function navxt_breadcrumb_linked(bool $linked, array $types, int $id = null): bool {
    $post_type = Program::POST_TYPE;

    if ($linked) {
        /* If "Link Current Item" turned on, this will be true and
         * we have nothing to do. 
         */
        return true;
    }

    if (is_singular($post_type) && in_array('post-' . $post_type, $types, true)) {
        /**
         * ID is null for subpages and we don't want to "Link Current Item."
         * ID is true for the Program itself and we do want them linked
         * because they are not the current item.
         */
        return (bool) $id;
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

    if (pdl_is_filtered_results(Plugin::post_types())) {
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
        [
            'text' => get_filtered_results_breadcrumb_label(),
            'url' => null
        ]
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

    if (pdl_is_filtered_results(Plugin::post_types())) {
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
    if (aioseo()->breadcrumbs->showCurrentItem()) {
        $crumb = get_program_subpage_crumb();
        $crumbs[] = [
            'label' => $crumb['text'],
            'link'  => $crumb['url'],
        ];
    }

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
    
    $crumbs[] = [
        'label' => get_filtered_results_breadcrumb_label(),
        'link' => ''
    ];

    return $crumbs;
}


/**
 * Updates the Yoast trail for program subpages and filtered results.
 *
 * Called on filter: rank_math/frontend/breadcrumb/items
 *
 * @param array $crumbs The current trail of crumbs.
 * @param Breadcrumbs $class The current breadcrumb object.
 * @return array The filtered trail of crumbs.
 */
function rankmath_update_trail(array $crumbs, \RankMath\Frontend\Breadcrumbs $class): array {
    if (is_singular(Program::POST_TYPE)) {
        return rankmath_add_subpage($crumbs);
    }

    if (pdl_is_filtered_results(Plugin::post_types())) {
        return rankmath_replace_trail($crumbs);
    }

    return $crumbs;
}

/**
 * Adds the current subpage crumb to the AiOSEO trail.
 *
 * @param array $crumbs The current trail of crumbs.
 * @return array The filtered trail of crumbs.
 */
function rankmath_add_subpage($crumbs) {
    $hide_title = \RankMath\Helper::get_settings('general.breadcrumbs_remove_post_title');

    if (!$hide_title) {
        $crumb = get_program_subpage_crumb();
        $crumbs[] = array_values($crumb);
    }

    return $crumbs;
}

/**
 * Rebuild the entire RankMath trail for the current archive.
 *
 * @param array $crumbs The current trail of crumbs.
 * @return array The new trail of crumbs.
 */
function rankmath_replace_trail(array $crumbs): array {
    $new_crumbs = [];
    $show_home = \RankMath\Helper::get_settings('general.breadcrumbs_home');

    if ($show_home) {
        $new_crumbs[] = array_shift($crumbs);
    }

    $new_crumbs[] = array_values(get_archive_crumb());
    $new_crumbs[] = [
        get_filtered_results_breadcrumb_label(),
        ''
    ];

    return $new_crumbs;
}
