<?php
/**
 * ACF related functionality.
 * 
 * @version 0.1.0
 * @package nvis-programs
 * @since 0.1.0
 */

namespace InvisibleUs\Programs;

add_action('plugins_loaded', __NAMESPACE__ . '\maybe_load_acf');
add_action('acf/init', __NAMESPACE__ . '\acf_init');

function maybe_load_acf() {
    // If ACF is already loaded, we can bail.
    if (class_exists('ACF')) {
        // TODO: Add minimum version number handling.
        return;
    }

    $subpath = '/src/acf/';
    define('NVISP_ACF_PATH', Plugin::$path . $subpath);
    define('NVISP_ACF_URL', Plugin::$url . $subpath);

    include_once(NVISP_ACF_PATH . 'acf.php');

    add_filter('acf/settings/url', __NAMESPACE__ . '\acf_settings_url');
    add_filter('acf/settings/show_admin', '__return_false');
}

function acf_settings_url(string $url) {
    return NVISP_ACF_URL;
}

function acf_init(): void {
    acf_add_options_page(Plugin::$options_page);

    $field_groups = [
        (new Plugin())::$field_groups[0],
        get_program_acf_fields(),
        ProgramType::$field_groups[0],
        Course::$field_groups[0]
    ];

    if (!Person::is_block_editor_enabled()) {
        $field_groups[] = Person::$field_groups[0];
    }

    foreach ($field_groups as $group) {
        acf_add_local_field_group($group);
    }

    return;
}

function get_program_acf_fields(): array {
    $group = Program::$field_groups[0];

    $group['fields'] = array_merge(
        $group['fields'],
        ProgramSubpageManager::get_enabled_subpage_fields()
    );

    return $group;
}
