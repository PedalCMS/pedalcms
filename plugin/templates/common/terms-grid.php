<?php
$defaults = [
    'title_tag'          => 'h2',
    'show_image'         => true,
    'show_description'   => true,
    'show_num_posts'     => true,
    'show_posts_link'    => true,
    'label_posts'        => 'Posts',
    'label_posts_single' => 'Post',
    'label_sr_text'      => 'in %s',
    'posts_link_prefix'  => 'Show',
    'wrapper_class'      => '',
    'columns'            => 2,
    'image_size'         => 'medium',
];

$args = pdl_parse_template_args($args, $defaults, $template);
$args['title_tag'] = pdl_sanitize_title_tag($args['title_tag'], $defaults['title_tag']);

$args['columns'] = max(1, min(4, $args['columns']));

$classes = [
    'terms-grid',
    $args['show_image'] ? 'has-images' : 'no-images',
    $args['wrapper_class']
];

if (!empty($args['terms'])) :
    $classes[] = ($args['terms'][0])->taxonomy . '-terms-grid';
?>
<ul class="<?php echo implode(' ', $classes); ?>"
    data-columns="<?php echo $args['columns']; ?>">
    <?php
    foreach ($args['terms'] as $term) :
    ?>
    <li class="term">
        <div class="term__title-group">
            <?php printf('<%s class="term__title">', $args['title_tag']); ?>
            <a
                href="<?php echo esc_url(get_term_link($term, $term->taxonomy)); ?>"><?php echo esc_html($term->name); ?></a>
            <?php printf('</%s>', $args['title_tag']); ?>
        </div>

        <?php
        if ($args['show_image']) :
            $args['term'] = $term;
            pdl_get_template_part('common/term-featured-image', $args);
        endif;
        ?>

        <?php if ($args['show_description']) : ?>
        <div class="term__description"><?php echo  $term->description; ?>
        </div>
        <?php endif; ?>

        <?php if ($args['show_posts_link']) : ?>
        <div class="term__posts-link">
            <a
                href="<?php echo esc_url(get_term_link($term, $term->taxonomy)); ?>">
                <?php printf(
                    '%s %s %s',
                    esc_html($args['posts_link_prefix']),
                    $args['show_num_posts'] ? number_format((int) $term->count) : '',
                    esc_html($args['label_posts'])
                ); ?>
                <span class="screen-reader-text"><?php printf($args['label_sr_text'], esc_html($term->name)); ?>
                </span>
            </a>
        </div>
        <?php endif; ?>

    </li>
    <?php endforeach; ?>
</ul>
<?php endif;
