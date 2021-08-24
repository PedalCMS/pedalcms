<?php

use function InvisibleUs\Programs\get_program_related_posts;

$posts = nvis_prog_get_related_posts();

if (!empty($posts)) : ?>
    <div class="related-post-list">
        <?php foreach ($posts as $post) : ?>
            <article class="related-post">
                <?php if (has_post_thumbnail($post)) : ?>
                    <div class="related-post__image-wrapper">
                        <?php echo get_the_post_thumbnail($post, 'medium', ['class' => 'related-post__image']); ?>
                    </div>
                <?php endif; ?>
                    
                <div class="related-post__wrapper">
                    <header class="related-post__header">
                        <h3 class="related-post__title">
                            <a href="<?php echo esc_url(get_permalink($post)); ?>">
                                <?php echo get_the_title($post); ?>
                            </a>
                        </h3>
                    </header>
                    <div class="related-post__content"><?php echo get_the_excerpt($post); ?></div>
                    <?php // TODO: Make this optional and filterable. 
                    ?>
                    <p class="related-post__more">
                        <a class="related-post__more-link" href="<?php echo esc_url(get_permalink($post)); ?>">
                            Read More
                        </a>
                    </p>
                </div>
            </article>
        <?php endforeach; ?>

        <?php if (get_field('news_show_all_link')) :?>
        <a href="<?php echo esc_url(get_term_link(get_field('news_tag'))); ?>">Show all posts</a>
        <?php endif; ?>
        
    </div>
<?php else : ?>
    <p class="empty-state-message">No posts found.</p>
<?php endif; 