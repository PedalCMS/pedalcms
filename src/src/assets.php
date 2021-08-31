<?php

namespace InvisibleUs\Programs;

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\register_assets');

function register_assets() {
    if (!is_admin() && (is_singular('nvis_program') || is_post_type_archive('nvis_program'))) {
        wp_enqueue_style(
            'nvis-program-base',
            NVIS_PROGRAMS_URL . '/assets/css/base.css'
        );
    }
}
