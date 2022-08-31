<?php

$defaults = [
    'post_type'     => get_post_type(),
    'image_size'    => 'medium',
    'image_align'   => 'right',
    'wrapper_class' => '',
    'featured_img'  => null
];

$args = nvis_parse_template_args($args, $defaults, $template);
$featured_img = $args['featured_img'];
    
$classes = [
    'featured-image',
    'post-type-image',
    $args['wrapper_class'],
    nvis_get_align_class($args['image_align']),
];

$classes[] = $featured_img ? 'post-type-image--placeholder' : '';

$img = $featured_img ? wp_get_attachment_image($featured_img, $args['image_size']) : '';

printf('<div class="%s">%s</div>', implode(' ', $classes), $img);
