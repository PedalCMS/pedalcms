<?php

$defaults = [
    'term'        => get_queried_object(),
    'link_image'  => true,
    'image_size'  => 'medium',
    'image_align' => 'none',
    'wrapper_class' => '',
    'featured_img' => null,
];

$args = nvis_parse_template_args($args, $defaults, $template);
$featured_img = $args['featured_img'];
$term = $args['term'];

if (!$featured_img && $term instanceof WP_Term) {
    $featured_img = get_term_meta($term->term_id, 'featured_image', true);
}

$classes = [
    'featured-image',
    'term__image',
    $args['wrapper_class'],
    nvis_get_align_class($args['image_align']),
];

$classes[] = !$featured_img ? 'term__image--placeholder' : '';

$img = $featured_img ? wp_get_attachment_image($featured_img, $args['image_size']) : '';

if ($img) {
    if ($args['link_image']) {
        $img = sprintf(
            '<a href="%s">%s</a>',
            esc_url(get_term_link($term, $term->taxonomy)),
            $img
        );
    }

    echo sprintf('<div class="%s">%s</div>', implode(' ', $classes), $img);
}
