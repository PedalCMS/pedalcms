<?php
/**
 * Template for displaying number of results in archives and filtered search.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post_type = get_post_type();
$post_type = get_post_type_object($post_type);

if ($post_type) {
    $label_single_post = strtolower($post_type->labels->singular_name);
    $label_posts = strtolower($post_type->labels->name);
} else {
    $label_single_post = nvis_prog_get_label('single_post');
    $label_posts = nvis_prog_get_label('posts');
}

$defaults = [
    'label_single_post'      => $label_single_post,
    'label_posts'            => $label_posts,
    'label_filtered_results' => nvis_prog_get_label('filtered_results'),
    'label_showing'          => nvis_prog_get_label('showing'),
    'label_showing_of'       => nvis_prog_get_label('showing_of'),
    'wp_query'               => null,
];

$args = wp_parse_args($args, $defaults);
$wp_query = $args['wp_query'];

if (!$wp_query) {
    global $wp_query;
}

$post_type = $wp_query->get('post_type');
$per_page = (int) $wp_query->get('posts_per_page');
$page = $wp_query->get('paged');
$page = $page ? $page : 1;
$first = ($page - 1) * $per_page + 1;
$last = $first + ($wp_query->post_count - 1);
$showing_all = $wp_query->post_count === $wp_query->found_posts;

$label = $args['label_posts'];

if ($wp_query->found_posts) {
    if ($showing_all) {
        if ($wp_query->found_posts == 1) {
            $label = $args['label_single_post'];
        }
        $num_results = sprintf(
            '%s %s %s.',
            esc_html($args['label_showing']),
            $wp_query->found_posts,
            $label
        );
    } else {
        $num_results = sprintf(
            esc_html($args['label_showing_of']),
            number_format($first),
            number_format($last),
            number_format($wp_query->found_posts),
            $label
        );
    }
}

/**
 * Fires before the number of results is loaded.
 *
 * @since 0.1
 *
 */
do_action('nvis/careers/before_num_results');

if ($wp_query->found_posts) : ?>
<div class="num-results">
    <?php if (nvis_is_filtered_results($post_type)) : ?>
    <strong class="num-results__filtered"><?php echo esc_html($args['label_filtered_results']);?>:</strong>
    <?php endif; ?>

    <span class="num-results__value"><?php echo $num_results; ?></span>
</div>
<?php endif;
/**
 * Fires after the number of results is loaded.
 *
 * @since 0.1
 *
 */
do_action('nvis/careers/after_num_results');
