<?php
/**
 * The template for displaying the a featured image for a Person.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'img_size'   => 'medium',
    'attributes' => null,
    'link_image' => true
];

$args = nvis_parse_template_args($args, $defaults, $template);

?>
<div class="person-featured-image featured-image">
    <?php
    if ($args['link_image']):
        echo sprintf('<a href="%s">', esc_url(get_permalink($post)));
    endif;

    if (has_post_thumbnail($post)):
        echo get_the_post_thumbnail($post, $args['img_size'], $args['attributes']);
    else:
        nvis_prog_get_template_part('single-person/featured-image-placeholder');
    endif;

    if ($args['link_image']):
        echo '</a>';
    endif;
    ?>
</div>