<?php
/**
 * Template tags shared across the plugin suite.
 *
 * @package NVISPrograms
 * @since 0.1.0
 */

if (!function_exists('pdl_args_or_global')) :
/**
 * Returns the args array value if available, global value if not.
 *
 * @since 0.1.0
 *
 * @param string $key The key to test.
 * @param array $args The args array to check.
 * @return mixed The 'key' value in args or global array.
 */
function pdl_args_or_global(string $key, array $args) {
    if (isset($args[$key])) {
        return $args[$key];
    }

    if (isset($GLOBALS[$key])) {
        return $GLOBALS[$key];
    }

    return null;
}

endif;


if (!function_exists('pdl_parse_template_args')) :
/**
 * Merges user defined arguments into defaults array for the given template.
 *
 * The only purpose this function serves is to provide a single point at which
 * to filter the default arguments of a template. The actual work is performed
 * by `wp_parse_args`.
 *
 * @since 0.1
 *
 * @param array $args The user defined args.
 * @param array $defaults The template defaults.
 * @param string $template The calling template.
 * @return array The final merged args.
 */
function pdl_parse_template_args(array $args, array $defaults, string $template): array {
    /**
     * Allows users to override the template defaults.
     *
     * @since 0.1
     *
     * @param array $defaults The set of defaults for the template.
     * @param string $template The current template.
     * @param array $args The args passed to the template.
     */
    $defaults = apply_filters( 'pdl/template_defaults', $defaults, $template, $args );

    return wp_parse_args( $args, $defaults );
}

endif;



if (!function_exists('pdl_sanitize_title_tag')) :
/**
 * Checks a tag against an allowed list.
 *
 * @since 0.1
 *
 * @param string $tag The tag to check.
 * @param string $default The fallback tag.
 * @return string The safe html title tag.
 */
function pdl_sanitize_title_tag($tag, string $default): string {
    $allowed_tags = ['h1','h2','h3','h4','h5','h6','p','div'];

    if (!in_array($tag, $allowed_tags, true)) {
        $tag = $default;
    }

    return $tag;
}

endif;


if (!function_exists('pdl_get_post_type_label')) :
/**
 * Gets a single particular label for the post type.
 *
 * @param string $post_type The post type key.
 * @param string $label_key The key of the label (See {@link https://developer.wordpress.org/reference/functions/get_post_type_labels/})
 * @param string $fallback_key A label key to use as a fallback if label_key doesn't exist.
 * @return mixed The label matching label_key on success. Null on failure.
 */
function pdl_get_post_type_label($post_type, string $label_key, string $fallback_key = '') {
    $post_type = $post_type ? $post_type : get_post_type();
    $post_type = get_post_type_object($post_type);

    if (!$post_type) {
        return null;
    }

    return
        $post_type->labels->{$label_key} ??
        $post_type->labels->{$fallback_key} ??
        null;
}

endif;


if (!function_exists('pdl_get_taxonomy_label')) :
/**
 * Gets a single particular label for the taxonomy.
 *
 * @param string $taxonomy The taxonomy key.
 * @param string $label_key The key of the label (See {@link https://developer.wordpress.org/reference/functions/get_taxonomy_labels/})
 * @param string $fallback_key A label key to use as a fallback if label_key doesn't exist.
 * @return mixed The label matching label_key on success. Null on failure.
 */
function pdl_get_taxonomy_label(string $taxonomy, string $label_key, string $fallback_key = '') {
    $taxonomy = get_taxonomy($taxonomy);

    if (!$taxonomy) {
        return null;
    }

    return
        $taxonomy->labels->{$label_key} ??
        $taxonomy->labels->{$fallback_key} ??
        null;
}

endif;


if (!function_exists('pdl_get_heading_tag')) :
/**
 * Returns the tag name of a corresponding heading level.
 *
 * @since 0.1
 *
 * @param integer $level The level of heading desired, 1-6.
 * @return string The resulting heading tag name.
 */
function pdl_get_heading_tag(int $level): string {
    $level = max(1, min(6, $level));

    return 'h' . $level;
}


endif;

if (!function_exists('pdl_is_filtered_results')):
/**
 * Determines if the current view is a filtered archive view.
 *
 * @since 0.1
 *
 * @param mixed $post_type The post_type to test, either a single string or an array of post_type strings.
 * @return bool
 */
function pdl_is_filtered_results($post_type): bool {
    return
    is_post_type_archive($post_type) &&
    (is_search() || is_tax());
}

endif;


if (!function_exists('pdl_article_id_attr')):
/**
 * Generates the id attribute for the article element of a post.
 *
 * @since 0.1
 *
 * @param mixed $post_id The id of the post.
 * @param bool $echo Whether to output the result.
 * @return string The id attribute string, not including the id declaration.
 */
function pdl_article_id_attr($post_id = 0, bool $echo = false): string {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $id = apply_filters(
        'pdl/article_id_attr',
        'article-' . $post_id,
        $post_id
    );

    if ($echo) {
        echo $id;
    }

    return $id;
}

endif;


if (!function_exists('pdl_back_to_top_link')):
/**
 * Generates a back-to-top HTML link.
 *
 * @since 0.1
 *
 * @param string $target The id of an existing HTML element without the `#`
 * @param boolean $echo Whether or not to output the resulting link.
 * @return string The resulting link.
 */
function pdl_back_to_top_link(string $target = '', bool $echo = true): string {
    if (!$target) {
        $target = pdl_article_id_attr('', false);
    }
    /**
     * Filters the text that appears in the text portion of Back to Top links.
     *
     * The text will get run through `esc_html()` so you should not do that
     * when you filter it.
     *
     * @since 0.1
     *
     * @param $text The text to filter.
     */
    $text = apply_filters('pdl/back_to_top_text', 'Back to Top');
    /**
     * NOTE: The text here cannot be replaced with a call to Plugin::get_label
     * since this is a shared function between both plugins.
     */

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


if (!function_exists('pdl_post_thumbnail_or_fallback')) :
/**
 * Generates an HTML img tag for a post, either the post_thumbnail or provided fallback.
 *
 * @since 0.1
 *
 * @param mixed $post Post ID or WP_Post object. Default is global `$post`.
 * @param int $fallback_id Image attachment ID.
 * @param string|array $size The desired image size. Default is 'medium'.
 * @param string|array $attrs Optional. Query string or array of attributes. Default empty.
 * @return string The img tag.
 */
function pdl_post_thumbnail_or_fallback($post = null, $fallback_id = null, $size = 'medium', $attrs = ''): string {
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


if (!function_exists('pdl_get_align_class')) :
/**
 * Gets a WordPress native alignment CSS class name.
 *
 * @since 0.1
 *
 * @param string $align The desired alignment. Defaults to 'none'.
 * @return string The alignment class.
 */
function pdl_get_align_class($align): string {
    $align = in_array($align, ['left','right','center','none'], true)
        ? $align
        : 'none';

    $class = 'align' . $align;

    return $class;
}

endif;


if (!function_exists('pdl_get_the_term_list')) :
/**
 * Retrieves a post's terms in a list with the specified format.
 *
 * The purpose of this function is to offer an option _NOT_ to link the terms.
 * If linked terms are desired, the work is handed off the WP's native
 * `get_the_term_list`. The format of the arguments match that function
 * exactly.
 *
 * @since 0.1
 *
 * @param int|WP_Post $post Post ID or object.
 * @param string $taxonomy  Taxonomy name.
 * @param string $before    Optional. String to use before the terms. Default empty.
 * @param string $sep       Optional. String to use between the terms. Default empty.
 * @param string $after     Optional. String to use after the terms. Default empty.
 * @return string|false|WP_Error A list of terms on success, false if there are no terms,
 *                               WP_Error on failure.
 */
function pdl_get_the_term_list($post, $taxonomy, string $before = '', string $sep = ', ', string $after = '', bool $link_terms = true) {
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

    /**
     * Filters the HTML formatted term list.
     *
     * @since 0.1
     *
     * @param string $list The formatted HTML, either linked or not.
     * @param string $taxonomy The taxonomy name of the terms.
     * @param int|WP_Post $post Post ID or object.
     */
    return apply_filters('pdl/terms_list', $list, $taxonomy, $post);
}

endif;


if (!function_exists('pdl_toggletip')) :

/**
 * Generates the HTML for a ToggleTip.
 *
 * This feature relies on the registered JS file 'nvis-global'. Make sure that
 * this file is enqueued when using ToggleTips.
 *
 * @param string $content The contents of the tip popup.
 * @param string $aria_label The `aria-label` attribute of the toggle button.
 * @param bool $echo Whther to output the result.
 * @return string The generated HTML string.
 */
function pdl_toggletip(string $content, string $aria_label, bool $echo = true): string {

    /**
     * Filters the text that appears on the ToggleTip button.
     *
     * Note that the expected button text is a single character. Any HTML can
     * be used, including SVG or an img tag, but anything other than a single
     * character will likely impact the styling of the button. You should
     * escape any HTML before returning it.
     *
     * @param string $button_text The button text.
     */
    $button_text = apply_filters( 'pdl/toggletip_button_text', '?' );

    $toggletip = sprintf('
        <span class="toggletip">
            <button class="toggletip__toggle" type="button" aria-label="%s" data-toggletip-content="%s">%s</button>
            <span role="status"></span>
        </span>',
        esc_attr($aria_label),
        esc_attr($content),
        $button_text
    );

    if ($echo) {
        echo $toggletip;
    }

    return $toggletip;
}

endif;
