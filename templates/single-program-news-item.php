<?php 
    $post = $data['post'] ?? null; 
    $classes = ['related-post'];
    $is_featured = $data['is_featured'] ?? false;

    if ($is_featured) {
        $classes[] = 'related-post--featured';
    }

    if (has_post_thumbnail($post)) {
        $classes[] = 'related-post--has-image';
    }

    
    if ($post) :?>
    <article class="<?php echo implode(' ', $classes); ?>">  
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
<?php endif; 
