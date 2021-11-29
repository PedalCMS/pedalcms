<?php
/**
 * The template for displaying a list of posts, for use on the News subpage.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

// TODO: Figure out how to prevent unnecessary DB calls here (when args passed).
$post = nvis_args_or_global('post', $args);
$featured_posts = get_field('news_featured_posts', $post);
$not_in = !empty($featured_posts) ?
    array_column($featured_posts, 'ID') :
    [];

$defaults = [
    'featured_posts'      => $featured_posts,
    'posts'               => nvis_prog_get_related_posts($post, $not_in),
    'news_tag'            => get_field('news_tag', $post),
    'show_all_posts_link' => get_field('news_show_all_link', $post),
];

$args = wp_parse_args($args, $defaults);

if (!empty($args['featured_posts']) || !empty($args['posts'])) : ?>

<?php if (!empty($args['featured_posts'])) : ?>
<div class="related-post-list related-post-list--featured">
    <?php
    foreach ($args['featured_posts'] as $p) :
        nvis_prog_get_template_part('single-program/news-item', ['post' => $p, 'is_featured' => true]);
    endforeach;
    ?>
</div>
<?php endif; ?>

<?php if (!empty($args['posts'])) : ?>
<div class="related-post-list">
    <?php
    foreach ($args['posts'] as $p) :
        nvis_prog_get_template_part('single-program/news-item', ['post' => $p]);
    endforeach; ?>
</div>
<?php endif; ?>

<?php if ($args['show_all_posts_link']) :?>
<a class="button button-secondary"
    href="<?php echo esc_url(get_term_link($args['news_tag'])); ?>">Show
    All Posts</a>
<?php endif; ?>

<?php else : ?>
<p class="empty-state-message">No posts found.</p>
<?php endif;
