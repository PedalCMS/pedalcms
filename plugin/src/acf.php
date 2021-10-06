<?php
/**
 * ACF related functionality.
 * 
 * @package NVISPrograms
 * @since 0.1.0
 */

namespace InvisibleUs\Programs;

add_action('plugins_loaded', __NAMESPACE__ . '\maybe_load_acf');
add_action('acf/init', __NAMESPACE__ . '\acf_init');

/**
 * Loads bundled ACF Pro if ACF not already loaded.
 *
 * @return void
 */
function maybe_load_acf(): void {
    if (class_exists('ACF')) {
        // TODO: Add minimum version number handling.
        // TODO: Figure out how to deal with Free/Pro discrepancy.
        return;
    }

    $subpath = '/src/acf/';
    define('NVISP_ACF_PATH', Plugin::$path . $subpath);
    define('NVISP_ACF_URL', Plugin::$url . $subpath);

    include_once(NVISP_ACF_PATH . 'acf.php');

    add_filter('acf/settings/url', __NAMESPACE__ . '\acf_settings_url');
    add_filter('acf/settings/show_admin', '__return_false');

    return;
}

/**
 * Returns the ACF settings URL override.
 *
 * @param string $url
 * @return void
 */
function acf_settings_url(string $url) {
    return NVISP_ACF_URL;
}

/**
 * Loads all the ACF Field Groups configured throughout the plugin.
 *
 * @return void
 */
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

/**
 * Merges all subpage fields into the program field group. 
 *
 * @return array
 */
function get_program_acf_fields(): array {
    $group = Program::$field_groups[0];

    $group['fields'] = array_merge(
        $group['fields'],
        ProgramSubpageManager::get_enabled_subpage_fields()
    );

    return $group;
}
