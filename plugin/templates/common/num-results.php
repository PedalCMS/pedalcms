<?php
/**
 * Template for displaying number of results in archives and filtered search.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$wp_query = $args['wp_query'] ?? null;
$label = $args['label'] ?? 'posts';
$label_single = $args['label_single'] ?? 'post';

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

/**
 * Fires before the number of results is loaded.
 *
 * @since 0.1
 *
 */
do_action('nvis/programs/before_num_results');


if ($wp_query->found_posts) : ?>
<div class="num-results">
    <?php if (nvis_prog_is_filtered_results($post_type)) : ?>
    <strong class="num-results__filtered">Filtered Results:</strong>
    <?php endif; ?>

    <span class="num-results__value">
        <?php
    if ($showing_all) {
        if ($wp_query->found_posts == 1) {
            $label = $label_single;
        }
        echo sprintf('Showing %s %s.', $wp_query->found_posts, $label);
    } else {
        echo sprintf(
            'Showing %s–%s of %s %s.',
            number_format($first),
            number_format($last),
            number_format($wp_query->found_posts),
            $label
        );
    }
    ?>
    </span>
</div>
<?php endif;
/**
 * Fires after the number of results is loaded.
 *
 * @since 0.1
 *
 */
do_action('nvis/programs/after_num_results');
