<?php
/**
 * The template for displaying a single Post item, for use on the News subpage.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'post'                => null,
    'is_featured'         => false,
    'show_image'          => true,
    'show_permalink'      => true,
    'image_align'         => 'right',
    'image_size'          => 'thumbnail',
    'image_wrapper_class' => 'related-post__image-wrapper'
];

$args = wp_parse_args($args, $defaults);

if ($args['post']) :
    $post = $args['post'];
    $classes = ['related-post'];

    if ($args['is_featured']) {
        $classes[] = 'related-post--featured';
    }

    if (has_post_thumbnail($post)) {
        $classes[] = 'related-post--has-image';
    }

?>
<article
    class="<?php echo implode(' ', $classes); ?>">

    <?php
    if ($args['show_image'] && has_post_thumbnail($post)) :
        nvis_prog_get_template_part('common/post-featured-image', $args);
    endif;
    ?>

    <div class="related-post__wrapper">
        <header class="related-post__header">
            <h3 class="related-post__title">
                <a
                    href="<?php echo esc_url(get_permalink($post)); ?>">
                    <?php echo get_the_title($post); ?>
                </a>
            </h3>
        </header>
        <div class="related-post__content"><?php echo get_the_excerpt($post); ?>
        </div>

        <?php if ($args['show_permalink']): ?>
        <p class="related-post__more">
            <a class="related-post__more-link"
                href="<?php echo esc_url(get_permalink($post)); ?>">
                Read More
            </a>
        </p>
        <?php endif; ?>

    </div>
</article>
<?php endif;
