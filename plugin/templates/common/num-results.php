<?php
/**
 * Template for displaying number of results in archives and filtered search.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'wp_query'        => null,
    'label'           => 'posts',
    'label_single'    => 'post',
    'showing_prefix'  => 'Showing',
    'filtered_prefix' => 'Filtered Results'
];

$args = wp_parse_args($args, $defaults);

if ($args['wp_query']) {
    $wp_query = $args['wp_query'];
} else {
    global $wp_query;
}

$post_type = $wp_query->get('post_type');
$per_page = (int) $wp_query->get('posts_per_page');
$page = $wp_query->get('paged');
$page = $page ? $page : 1;
$first = ($page - 1) * $per_page + 1;
$last = $first + ($wp_query->post_count - 1);
$showing_all = $wp_query->post_count === $wp_query->found_posts;
$label = $wp_query->found_posts === 1 ? $args['label_single'] : $args['label'];

/**
 * Fires before the number of results is loaded.
 *
 * @since 0.1
 *
 * @param array $args The template arguments.
 *
 */
do_action('nvis/programs/before_num_results', $args);

if ($wp_query->found_posts) : ?>
<div class="num-results">
    <?php
    if (nvis_is_filtered_results($post_type)) :
        echo sprintf(
            '<strong class="num-results__filtered">%s<span class="separator">:</span></strong>',
            esc_html($args['filtered_prefix'])
        );
    endif;
    ?>

    <span class="num-results__value">
        <?php
    if ($showing_all) :
        echo sprintf(
            '%s %s %s.',
            esc_html($args['showing_prefix']),
            $wp_query->found_posts,
            $label
        );
    else:
        echo sprintf(
            '%s %s–%s of %s %s.',
            esc_html($args['showing_prefix']),
            number_format($first),
            number_format($last),
            number_format($wp_query->found_posts),
            $label
        );
    endif;
    ?>
    </span>
</div>
<?php endif;
/**
 * Fires after the number of results is loaded.
 *
 * @since 0.1
 *
 * @param array $args The template arguments.
 *
 */
do_action('nvis/programs/after_num_results', $args);
