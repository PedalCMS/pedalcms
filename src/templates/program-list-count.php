<?php
global $wp_query;
$per_page = (int) get_query_var('posts_per_page');
$page = get_query_var('paged');
$page = $page ? $page : 1;
$first = ($page - 1) * $per_page + 1;
$last = $first + ($wp_query->post_count - 1);
$showing_all = $wp_query->post_count === $wp_query->found_posts;

if ($wp_query->found_posts) : ?>
<div class="program-list-count">
  <?php if (nvis_prog_is_filtered_results()) : ?>
    <strong class="program-list-count__filtered">Filtered Results:</strong>
  <?php endif; ?>

  <span class="program-list-count__value">
    <?php
    if ($showing_all) {
      echo sprintf('Showing %d programs.', $wp_query->found_posts);
    } else {
      echo sprintf(
        'Showing %d–%d of %d programs.',
        $first,
        $last,
        $wp_query->found_posts
      );
    }
    ?>
  </span>
</div>
<?php endif;

