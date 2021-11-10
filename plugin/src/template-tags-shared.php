<?php
/**
 * Template tags shared across the plugin suite.
 *
 * @package NVISPrograms
 * @since 0.1.0
 */


if (!function_exists('nvis_args_or_global')) :
/**
 * Returns the args array value if available, global value if not.
 *
 * @param string $key The key to test.
 * @param array $args The args array to check.
 * @return mixed The 'key' value in args or global array.
 */
function nvis_args_or_global(string $key, array $args) {
    if (isset($args[$key])) {
        return $args[$key];
    }

    if (isset($GLOBALS[$key])) {
        return $GLOBALS[$key];
    }

    return null;
}

endif;


if (!function_exists('nvis_sanitize_title_tag')) :
/**
 * Checks a tag against an allowed list.
 *
 * @param string $tag The tag to check.
 * @param string $default The fallback tag.
 * @return string The safe html title tag.
 */
function nvis_sanitize_title_tag(string $tag, string $default): string {
    $allowed_tags = ['h1','h2','h3','h4','h5','h6','p','div'];

    if (!in_array($tag, $allowed_tags, true)) {
        $tag = $default;
    }

    return $tag;
}

endif;


if (!function_exists('nvis_is_filtered_results')):
 /**
 * Determines if the current view is a filtered archive view.
 *
 * @param mixed $post_type The post_type to test.
 * @return bool
 */
 function nvis_is_filtered_results($post_type): bool {
     return
        is_post_type_archive($post_type) &&
        (is_search() || is_tax());
 }

endif;
