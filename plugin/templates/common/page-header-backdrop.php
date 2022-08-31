<?php

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'attachment_id'    => 0,
    'show_backdrop'    => false,
    'backdrop_size'    => 'large',
    'fallback_to_post' => true,
];

$args = nvis_parse_template_args($args, $defaults, $template);

if (empty($args['attachment_id']) && $args['fallback_to_post']) {
    $args['attachment_id'] = get_post_thumbnail_id($post);
}

if ($args['show_backdrop'] && $args['attachment_id']) :
    printf(
        '<div class="page-header__backdrop">%s</div>',
        wp_get_attachment_image(
            $args['attachment_id'],
            $args['backdrop_size'],
            false,
            ['alt' => '', 'title' => '']
        )
    );
endif;
