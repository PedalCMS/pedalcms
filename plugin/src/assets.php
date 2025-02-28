<?php
/**
 * Asset management.
 *
 * @package NVISPrograms
 * @since 0.1.0
 */

namespace PedalCMS\Core;

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\register_assets', 0);
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets');
add_action('admin_enqueue_scripts', __NAMESPACE__ . '\admin_enqueue_assets');

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

    $terms_grid = '/assets/css/terms-grid.min.css';
    wp_register_style(
        'nvis-terms-grid',
        Plugin::$url . $terms_grid,
        ['nvis-global'],
        filemtime(Plugin::$path . $terms_grid)
    );

    $global = '/assets/js/global.min.js';
    wp_register_script(
        'nvis-global',
        Plugin::$url . $global,
        [],
        filemtime(Plugin::$path . $global),
        true
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

    if (pdl_is_active_subpage('careers') && $presentation_mode !== 'none') {
        wp_enqueue_style('nvis-careers-base');
    }

    if (!is_admin()) {
        if ($presentation_mode !== 'none') {
            wp_enqueue_style('nvis-global');
        }

        if ($presentation_mode === 'full') {
            wp_enqueue_style('nvis-global-full');
        }
    }

    if (!is_admin() && $presentation_mode !== 'none') {
        if (is_singular()) {
            $post = get_post();

            if (strpos($post->post_content, '[pdl_terms_grid ')) {
                wp_enqueue_style('nvis-terms-grid');
            }
        }
    }

    $is_plugin_content = 
        is_singular(Plugin::post_types()) || 
        is_post_type_archive(Plugin::post_types()) ||
        is_tax(Plugin::taxonomies());

    if (!is_admin() && $is_plugin_content) {
        if ($presentation_mode !== 'none') {
            wp_enqueue_style('nvis-programs-base');
        }

        if ($presentation_mode === 'full') {
            wp_enqueue_style('nvis-programs-full');
        }
    }

    if (!is_admin()) {
        wp_enqueue_script('nvis-global');
    }
}

function admin_enqueue_assets() {
    global $pagenow;
    
    $is_post_edit = 
        in_array($pagenow, ['post.php', 'post-new.php']) &&
        in_array(get_post_type(), Plugin::post_types());

    if ($is_post_edit && Department::depends_on_college()) {
        $pdl_acf = '/admin/js/nvis-acf.min.js';

        wp_enqueue_script(
            'nvis-acf',
            Plugin::$url . $pdl_acf,
            ['acf'],
            filemtime(Plugin::$path . $pdl_acf),
            true
        );
    
        $pdl_acf_data = [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('pdl_acf_data'),
            'label_not_found' => __('No departments found', 'pedalcms')
        ];
    
        wp_localize_script('nvis-acf', 'nvisACFData', $pdl_acf_data);
    }
}
