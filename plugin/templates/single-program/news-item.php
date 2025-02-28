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
    'show_featured_label' => false,
    'show_image'          => true,
    'show_category'       => true,
    'show_excerpt'        => true,
    'show_permalink'      => true,
    'link_terms'          => true,
    'image_align'         => 'right',
    'image_size'          => 'small',
    'image_wrapper_class' => 'related-post__image-wrapper',
    'label_featured'      => pdl_get_label('featured'),
    'label_read_more'     => pdl_get_label('read_more'),
];

$args = pdl_parse_template_args($args, $defaults, $template);
$args['context'] = $template;
$args['link_image'] = true;

if ($args['post']) :
    $post = $args['post'];
    $classes = ['related-post'];

    if ($args['is_featured']) {
        $classes[] = 'related-post--featured';
    }

    if (has_post_thumbnail($post)) {
        $classes[] = 'related-post--has-image';
    }

    $classes[] = 'related-post--image-' . esc_attr($args['image_align']);

?>
<article
    class="<?php echo implode(' ', $classes); ?>">

    <?php
    if ($args['show_image'] && has_post_thumbnail($post)) :
        pdl_get_template_part('common/post-featured-image', $args);
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

            <?php if ($args['is_featured'] && $args['show_featured_label']) : ?>
            <span class="related-post__title-label label"><?php echo esc_html($args['label_featured']); ?></span>
            <?php endif; ?>

            <?php
            if ($args['show_category']) :
                echo
                    pdl_get_the_term_list(
                        $post,
                        'category',
                        '<span class="related-post__category">',
                        ',',
                        '</span>',
                        $args['link_terms']
                    );
            endif;
            ?>
        </header>

        <?php if ($args['show_excerpt']): ?>
        <div class="related-post__content"><?php echo get_the_excerpt($post); ?>
        </div>
        <?php endif; ?>

        <?php if ($args['show_permalink']): ?>
        <p class="related-post__more">
            <a class="related-post__more-link"
                href="<?php echo esc_url(get_permalink($post)); ?>">
                <?php echo esc_html($args['label_read_more']); ?>
            </a>
        </p>
        <?php endif; ?>

    </div>
</article>
<?php endif;
