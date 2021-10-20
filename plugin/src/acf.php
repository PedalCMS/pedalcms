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
add_filter('acf/update_value/type=relationship', __NAMESPACE__ . '\maybe_update_bidirectional_relationship', 10, 3);


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
        Course::$field_groups[0],
        Person::get_field_group()
    ];

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
    // TODO: Move this to Program class.
    $group = Program::$field_groups[0];

    $group['fields'] = array_merge(
        $group['fields'],
        ProgramSubpageManager::get_enabled_subpage_fields()
    );

    return $group;
}

function get_related_field_name($field_name) {
    $bidirectional = [
        'related_course_personnel' => 'related_person_courses',
    ];

    if (array_key_exists($field_name, $bidirectional)) {
        return $bidirectional[$field_name];
    }

    $rel_field_name = array_search($field_name, $bidirectional, true);

    if ($rel_field_name !== false) {
        return $rel_field_name;
    }

    return false;
}

function maybe_update_bidirectional_relationship($value, $post_id, $field) {
    $field_name = $field['name'];
    $global_name = 'nvis_is_updating_bidirectional';
    $rel_field_name = get_related_field_name($field_name);

    if (!empty($GLOBALS[ $global_name ])) {
        // We are already updating this bidirectional relationship.
        return $value;
    }

    if (!$rel_field_name) {
        // This is not a bidirectional relationship.
        return $value;
    }


    $old_value = get_field($field_name, $post_id, false);

    if (!is_array($value)) {
        $value = [];
    }

    if (!is_array($old_value)) {
        $old_value = [];
    }

    $add_to = array_diff($value, $old_value);
    $remove_from = array_diff($old_value, $value);

    // Begin the "critial section".
    $GLOBALS[$global_name] = 1;

    add_relationship($post_id, $add_to, $rel_field_name);
    remove_relationship($post_id, $remove_from, $rel_field_name);

    // End the "critical section".
    unset($GLOBALS[$global_name]);


    return $value;
}

function add_relationship(int $add_post, array $to_posts, string $field_name): void {
    if (!empty($to_posts)) {
        foreach ($to_posts as $post_id) {
            $rel_posts = get_field($field_name, $post_id);

            if (empty($rel_posts)) {
                $rel_posts = [];
            }

            $rel_posts[] = $add_post;
            update_field($field_name, $rel_posts, $post_id);
        }
    }

    return;
}

function remove_relationship(int $remove_post, array $from_posts, string $field_name): void {
    if (!empty($from_posts)) {
        foreach ($from_posts as $post_id) {
            $rel_posts = get_field($field_name, $post_id);

            if (empty($rel_posts)) {
                continue;
            }

            $i = array_search($remove_post, $rel_posts, true);

            if ($i !== false) {
                unset($rel_posts[$i]);
                update_field($field_name, $rel_posts, $post_id);
            }
        }
    }

    return;
}
