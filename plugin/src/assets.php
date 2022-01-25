<?php
/**
 * Asset management.
 *
 * @package NVISPrograms
 * @since 0.1.0
 */

namespace InvisibleUs\Programs;

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\register_assets', 0);
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets');

/**
 * Registers frontend assets.
 *
 * @return void
 */
function register_assets() {
    $global = '/assets/css/global.min.css';
    wp_register_style(
        'nvis-global',
        Plugin::$url . $global,
        [],
        filemtime(Plugin::$path . $global)
    );

    $base = '/assets/css/base.min.css';
    wp_register_style(
        'nvis-programs-base',
        Plugin::$url . $base,
        ['nvis-global'],
        filemtime(Plugin::$path . $base)
    );

    $global_full = '/assets/css/global-full.min.css';
    wp_register_style(
        'nvis-global-full',
        Plugin::$url . $global_full,
        ['nvis-global'],
        filemtime(Plugin::$path . $global_full)
    );

    $full = '/assets/css/full.min.css';
    wp_register_style(
        'nvis-programs-full',
        Plugin::$url . $full,
        ['nvis-global', 'nvis-programs-base'],
        filemtime(Plugin::$path . $full)
    );
}

/**
 * Enqueues frontend assets.
 *
 * @return void
 */
function enqueue_assets() {
    $presentation_mode = Plugin::get_option('presentation_mode');

    if (!$presentation_mode) {
        $presentation_mode = 'base';
    }

    if (nvis_prog_is_active_subpage('careers') && $presentation_mode !== 'none') {
        wp_enqueue_style('nvis-careers-base');
    }

    if (!is_admin()) {
        wp_enqueue_style('nvis-global');

        if ($presentation_mode === 'full') {
            wp_enqueue_style('nvis-global-full');
        }
    }

    if (!is_admin() && (
        is_singular([Program::POST_TYPE, Person::POST_TYPE, Course::POST_TYPE]) ||
        is_post_type_archive([Program::POST_TYPE, Person::POST_TYPE, Course::POST_TYPE])
    )) {
        if ($presentation_mode !== 'none') {
            wp_enqueue_style('nvis-programs-base');
        }

        if ($presentation_mode === 'full') {
            wp_enqueue_style('nvis-programs-full');
        }
    }
}
