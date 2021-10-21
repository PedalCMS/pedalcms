<?php
/**
 * Displays a simple list of post links.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

if (!empty($args['posts'])) : ?>
<ul class="post-links">
    <?php foreach ($args['posts'] as $post) :?>
    <li class="post-links__item">
        <a href="<?php echo esc_url(get_permalink($post)); ?>"><?php echo esc_html(get_the_title($post)); ?></a>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif;
