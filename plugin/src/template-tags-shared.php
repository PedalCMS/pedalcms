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

if (!function_exists('nvis_get_heading_tag')) :
/**
 * Returns the tag name of a corresponding heading level.
 *
 * @param integer $level The level of heading desired, 1-6.
 * @return string The resulting heading tag name.
 */
function nvis_get_heading_tag(int $level): string {
    $level = max(1, min(6, $level));

    return 'h' . $level;
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


if (!function_exists('nvis_article_id_attr')):
/**
 * Generates the id attribute for the article element of a post.
 *
 * @param mixed $post_id The id of the post.
 * @return string The id attribute string, not including the id declaration.
 */
function nvis_article_id_attr($post_id = 0, bool $echo = false): string {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $id = apply_filters(
        'nvis/article_id_attr',
        'article-' . $post_id,
        $post_id
    );

    if ($echo) {
        echo $id;
    }

    return $id;
}

endif;


if (!function_exists('nvis_back_to_top_link')):
/** */
function nvis_back_to_top_link(string $target = '', bool $echo = true): string {
    if (!$target) {
        $target = nvis_article_id_attr('', false);
    }

    $text = apply_filters('nvis/back_to_top_text', 'Back to Top');

    $link = sprintf(
        '<a class="back-to-top" href="#%s">%s</a>',
        esc_attr($target),
        esc_html($text)
    );

    if ($echo) {
        echo $link;
    }

    return $link;
}

endif;


if (!function_exists('nvis_post_thumbnail_or_fallback')) :

function nvis_post_thumbnail_or_fallback($post, $fallback_id, $size = 'medium', $attrs = ''): string {
    $post = get_post($post);

    if (has_post_thumbnail($post)) {
        return get_the_post_thumbnail($post, $size, $attrs);
    }

    if ($fallback_id) {
        return wp_get_attachment_image($fallback_id, $size, false, $attrs);
    }

    return '';
}

endif;

if (!function_exists('nvis_get_align_class')) :

function nvis_get_align_class(string $align): string {
    $align = in_array($align, ['left','right','center','none'], true)
        ? $align
        : 'none';

    $class = 'align' . $align;

    return $class;
}

endif;

if (!function_exists('nvis_get_the_terms_list')) :

function nvis_get_the_term_list($post, string $taxonomy, string $before = '', string $sep = ', ', string $after = '', bool $link_terms = true): string {
    if ($link_terms) {
        $list = get_the_term_list($post, $taxonomy, $before, $sep, $after);
    } else {
        $terms = get_the_terms($post, $taxonomy);

        if (is_wp_error($terms)) {
            return $terms;
        }

        if (empty($terms)) {
            return false;
        }

        $list = $before . implode($sep, wp_list_pluck($terms, 'name')) . $after;
    }

    return apply_filters('nvis/terms_list', $list, $taxonomy, $post);
}

endif;
