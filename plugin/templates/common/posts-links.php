<?php
defined('ABSPATH') || exit;

if (!empty($data['posts'])) : ?>
<ul class="post-links">
    <?php foreach ($data['posts'] as $post) :?>
    <li class="post-links__item">
        <a href="<?php echo esc_url(get_permalink($post)); ?>"><?php echo esc_html(get_the_title($post)); ?></a>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif;
