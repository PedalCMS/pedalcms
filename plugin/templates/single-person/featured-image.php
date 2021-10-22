<?php
/**
 * The template for displaying the a featured image for a Person.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$size = $args['img_size'] ?? 'medium';
$post = $args['post'] ?? get_post();
?>
<div class="person-featured-image">
    <a href="<?php echo esc_url(get_permalink($post)); ?>">
        <?php
    if (has_post_thumbnail($post)):
        echo get_the_post_thumbnail($post, $size);
    else:
        nvis_prog_get_template_part('single-person/featured-image-placeholder');
    endif;
    ?>
    </a>
</div>