<?php
/**
 * Asset management.
 *
 * @package NVISPrograms
 * @since 0.1.0
 */

namespace InvisibleUs\Programs;

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\register_assets');

/**
 * Registers and enqueues frontend assets.
 *
 * @return void
 */
function register_assets() {
    if (nvis_prog_is_active_subpage('careers')) {
        wp_enqueue_style('nvis-careers-base');
    }

    if (!is_admin()) {
        $global = '/assets/css/global.css';
        wp_enqueue_style(
            'nvis-global',
            Plugin::$url . $global,
            [],
            filemtime(Plugin::$path . $global)
        );
    }

    if (!is_admin() && (
        is_singular([Program::POST_TYPE, Person::POST_TYPE, Course::POST_TYPE]) ||
        is_post_type_archive([Program::POST_TYPE, Person::POST_TYPE, Course::POST_TYPE])
    )) {
        $base = '/assets/css/base.css';
        wp_enqueue_style(
            'nvis-program-base',
            Plugin::$url . $base,
            ['nvis-global'],
            filemtime(Plugin::$path . $base)
        );
    }
}
