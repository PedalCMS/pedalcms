<?php
defined('ABSPATH') || exit;

$size = $data['img_size'] ?? 'medium';
$post = $data['post'] ?? get_post();
?>
<div class="person-featured-image">
    <a href="<?php esc_url(get_permalink($post)); ?>">
        <?php
    if (has_post_thumbnail($post)):
        echo get_the_post_thumbnail($post, $size);
    else:
        nvis_prog_get_template_part('single-person/featured-image-placeholder');
    endif;
    ?>
    </a>
</div>