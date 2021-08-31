<?php

add_action('acf/init', 'nvis_programs_register_tuition_settings_page');

function nvis_programs_register_tuition_settings_page() {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(
            [
                'page_title'  => 'WP Program Pages',
                'menu_title'  => 'WP Program Pages',
                'menu_slug'   => 'wp-program-pages-settings',
                'capability'  => 'manage_options',
                'parent_slug' => 'options-general.php',
                'position'    => 7,
                'redirect'    => false,
            ]
        );
    }
}
