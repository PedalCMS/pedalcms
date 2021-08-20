<?php
$tag = get_field('news_tag');
if ($tag) {
    $posts = get_posts(['tag_id' => $tag]);
}

if ($tag && is_array($posts)) : ?>

    <?php if (!empty($posts)) : ?>
        <div class="related-post-list">
            <?php foreach ($posts as $post) : ?>
                <article class="related-post">
                    <header class="related-post__header">
                        <h3 class="related_post__title">
                            <a href="<?php echo esc_url(get_permalink($post)); ?>">
                                <?php echo get_the_title($post); ?>
                            </a>
                        </h3>
                    </header>
                    <div class="related-post__content"><?php echo get_the_excerpt($post); ?></div>
                    <?php // TODO: Make this optional and filterable. 
                    ?>
                    <p>
                        <a class="related-post__more-link" href="<?php echo esc_url(get_permalink($post)); ?>">
                            Read More
                        </a>
                    </p>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p class="empty-state-message">No posts found.</p>
    <?php endif; ?>

<?php endif; ?>