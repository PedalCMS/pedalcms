<?php

defined('ABSPATH') || exit;

$wp_query = $data['wp_query'] ?? null;
$posts_label = $data['posts_label'] ?? 'posts';

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

if ($wp_query->found_posts) : ?>
<div class="num-results">
    <?php if (nvis_prog_is_filtered_results($post_type)) : ?>
    <strong class="num-results__filtered">Filtered Results:</strong>
    <?php endif; ?>

    <span class="num-results__value">
        <?php
    if ($showing_all) {
        echo sprintf('Showing %s %s.', $wp_query->found_posts, $posts_label);
    } else {
        echo sprintf(
            'Showing %s–%s of %s %s.',
            number_format($first),
            number_format($last),
            number_format($wp_query->found_posts),
            $posts_label
        );
    }
    ?>
    </span>
</div>
<?php endif;
