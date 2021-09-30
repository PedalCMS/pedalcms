<?php
/**
 * Asset management.
 * 
 * @version 0.1.0
 * @package nvis-programs
 * @since 0.1.0
 */

namespace InvisibleUs\Programs;

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\register_assets');

function register_assets() {
    if (!is_admin() && (
        is_singular([Program::POST_TYPE, Person::POST_TYPE, Course::POST_TYPE]) ||
        is_post_type_archive([Program::POST_TYPE, Person::POST_TYPE, Course::POST_TYPE])
    )) {
        wp_enqueue_style(
            'nvis-program-base',
            Plugin::$url . '/assets/css/base.css'
        );
    }
}
