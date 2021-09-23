<?php
$size = $data['size'] ?? 'medium';
$post = $data['post'] ?? get_post();
?>
<div class="person-featured-image">
    <?php if (has_post_thumbnail($post)):?>
    <?php echo get_the_post_thumbnail($post, $size); ?>
    <?php else: ?>
    SVG goes here.
    <?php endif; ?>
</div>