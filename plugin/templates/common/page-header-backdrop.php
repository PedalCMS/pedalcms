<?php

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'show_backdrop'          => false,
    'backdrop_size'          => 'large',
    'fallback_attachment_id' => ''
];

$args = wp_parse_args($args, $defaults);

if ($args['show_backdrop']) :
    echo sprintf(
        '<div class="page-header__backdrop">%s</div>',
        nvis_post_thumbnail_or_fallback(
            $post,
            $args['fallback_attachment_id'],
            $args['backdrop_size']
        )
    );
endif;
