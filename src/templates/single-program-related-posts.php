<?php

$featured_posts = get_field('news_featured_posts');
$is_featured = true;

$posts = nvis_prog_get_related_posts(
    null, 
    array_column($featured_posts, 'ID')
);

if (!empty($featured_posts) && !empty($posts)) : ?>

    <?php if (!empty($featured_posts)) : ?>
    <div class="related-post-list related-post-list--featured">
        <?php foreach ($featured_posts as $post) : ?>
            <?php nvis_prog_get_template_part('single-program-news-item', compact('post','is_featured')); ?>
        <?php endforeach; ?>        
    </div>
    <?php endif; ?>

    <?php if (!empty($posts)) : ?>
    <div class="related-post-list">
        <?php foreach ($posts as $post) : ?>
            <?php nvis_prog_get_template_part('single-program-news-item', compact('post')); ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (get_field('news_show_all_link')) :?>
    <a href="<?php echo esc_url(get_term_link(get_field('news_tag'))); ?>">Show all posts</a>
    <?php endif; ?>

<?php else : ?>
    <p class="empty-state-message">No posts found.</p>
<?php endif; 
