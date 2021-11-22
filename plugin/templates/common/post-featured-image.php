<?php
/**
 * The template for displaying the featured image of a post.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'show_image'             => true,
    'image_size'             => 'medium',
    'image_align'            => 'right',
    'image_wrapper_class'    => '',
    'image_attributes'       => '',
    'fallback_attachment_id' => ''
];

$args = wp_parse_args($args, $defaults);

$align_class = in_array($args['image_align'], ['left','right','center','none'], true)
    ? $args['image_align']
    : 'right';

$align_class = 'align' . $align_class;
$classes = [
    'featured-image',
    $align_class,
    esc_attr($args['image_wrapper_class'])
];

$show_image = $args['show_image'] && (
    has_post_thumbnail($post) ||
    !empty($args['fallback_attachment_id'])
);

if ($show_image) :
    echo sprintf(
        '<div class="%s">%s</div>',
        implode(' ', $classes),
        nvis_post_thumbnail_or_fallback(
            $post,
            $args['fallback_attachment_id'],
            $args['image_size'],
            $args['image_attributes']
        )
    );
endif;
