<?php

namespace InvisibleUs\Programs;

add_action('acf/init', __NAMESPACE__ . '\register_settings_page');

function register_settings_page(): void {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(
            [
                'page_title'  => 'WP Program Pages Settings',
                'menu_title'  => 'WP Program Pages',
                'menu_slug'   => 'wp-program-pages-settings',
                'capability'  => 'manage_options',
                'parent_slug' => 'options-general.php',
                'position'    => 7,
                'redirect'    => false,
            ]
        );
    }

    return;
}
