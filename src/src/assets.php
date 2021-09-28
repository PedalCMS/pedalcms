<?php

namespace InvisibleUs\Programs;

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\register_assets');

function register_assets() {
    if (!is_admin() && (
        is_singular([Program::post_type, Person::post_type, Course::post_type]) ||
        is_post_type_archive([Program::post_type, Person::post_type, Course::post_type])
    )) {
        wp_enqueue_style(
            'nvis-program-base',
            Plugin::$url . '/assets/css/base.css'
        );
    }
}
