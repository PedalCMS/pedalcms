<?php
/**
 * The template for displaying a list of posts, for use on the News subpage.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'featured_posts'       => null,
    'posts'                => null,
    'news_tag'             => get_field('news_tag', $post),
    'show_all_posts_link'  => get_field('news_show_all_link', $post),
    'label_all_posts'      => nvis_prog_get_label('show_all_posts'),
    'label_no_posts_found' => nvis_get_post_type_label('post', 'not_found'),
];

$args = nvis_parse_template_args($args, $defaults, $template);

$featured_posts = $args['featured_posts'] ?? get_field('news_featured_posts', $post);
$posts = $args['posts'];

if (empty($posts) && $posts !== false) {
    $not_in = !empty($featured_posts) ?
        array_column($featured_posts, 'ID') :
        [];
    $posts = nvis_prog_get_related_posts($post, $not_in);
}

if (!empty($featured_posts) || !empty($posts)) : ?>

<?php if (!empty($featured_posts)) : ?>
<div class="related-post-list related-post-list--featured">
    <?php
    foreach ($featured_posts as $p) :
        nvis_prog_get_template_part('single-program/news-item', ['post' => $p, 'is_featured' => true]);
    endforeach;
    ?>
</div>
<?php endif; ?>

<?php if (!empty($posts)) : ?>
<div class="related-post-list">
    <?php
    foreach ($posts as $p) :
        nvis_prog_get_template_part('single-program/news-item', ['post' => $p]);
    endforeach; ?>
</div>
<?php endif; ?>

<?php if ($args['show_all_posts_link']) :?>
<a class="all-posts-link button button-secondary"
    href="<?php echo esc_url(get_term_link($args['news_tag'])); ?>"><?php echo esc_html($args['label_all_posts']); ?></a>
<?php endif; ?>

<?php else : ?>
<p class="empty-state-message"><?php echo esc_html($args['label_no_posts_found']); ?>
</p>
<?php endif;
