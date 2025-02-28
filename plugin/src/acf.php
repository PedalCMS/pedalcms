<?php
/**
 * ACF related functionality.
 *
 * @package PedalCMS
 * @since 0.1.0
 */

namespace PedalCMS\Core;

add_action('plugins_loaded', __NAMESPACE__ . '\maybe_load_acf', 0);
add_action('acf/init', __NAMESPACE__ . '\acf_init');
add_filter('acf/update_value/type=relationship', __NAMESPACE__ . '\maybe_update_bidirectional_relationship', 10, 3);
add_filter('acf/load_field/name=pdl_image_size_header', __NAMESPACE__ . '\choices_image_size_header');
add_filter('acf/load_field/name=search_filters', __NAMESPACE__ . '\choices_search_filters');
add_filter('acf/load_field/name=post_type', __NAMESPACE__ . '\choices_post_type');
add_filter('acf/prepare_field/name=department', __NAMESPACE__ . '\prepare_department');
add_filter('acf/prepare_field/type=taxonomy', __NAMESPACE__ . '\prepare_taxonomy_field');
add_action('acf/save_post', __NAMESPACE__ . '\save_options', 20);
add_action('admin_init', __NAMESPACE__ . '\maybe_flush_rules');

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
        Plugin::get_field_group(),
        Program::get_field_group(),
        ProgramType::get_field_group(),
        College::get_field_group(),
        Department::get_field_group(),
        Course::get_field_group(),
        Person::get_field_group(),
        PersonCategory::get_field_group(),
    ];

    foreach ($field_groups as $group) {
        acf_add_local_field_group($group);
    }

    return;
}

/**
 * Get the corresponding field of a post relationship.
 *
 * Uses a lookup table to match names of fields that constitute a bidirectional
 * relationship.
 *
 * @param string $field_name The name of the field to match.
 * @return mixed String name of related field. False on failure.
 */
function get_related_field_name(string $field_name) {
    $bidirectional = [
        'related_program_careers' => 'related_career_programs',
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

/**
 * Updates a bidirectional relationship when necessary.
 *
 * This function handles the necessary duplication of data to create
 * bidirectional relationships in ACF.
 *
 * Fires on: acf/update_value/type=relationship
 *
 * @param mixed $value The field value.
 * @param integer $post_id The post ID where the value is saved.
 * @param array $field  The field array containing all settings.
 * @return void
 */
function maybe_update_bidirectional_relationship($value, int $post_id, array $field) {
    $field_name = $field['name'];
    $global_name = 'pdl_is_updating_bidirectional';
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

/**
 * Adds the relationship value to the connected post(s).
 *
 * @param integer $add_post The source post.
 * @param array $to_posts The target posts to connect the source.
 * @param string $field_name The name of the relationship field.
 * @return void
 */
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
/**
 * Removes the relationship value from the connected post(s).
 *
 * @param integer $remove_post The source post.
 * @param array $from_posts The target posts to disconnect the source.
 * @param string $field_name The name of the relationship field.
 * @return void
 */
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

/**
 * Adds the list of registered image sizes to the choices.
 *
 * Called on filter: `acf/load_field/name=pdl_image_size_header`
 *
 * @param array $field The ACF field config.
 * @return array The filtered field config.
 */
function choices_image_size_header(array $field): array {
    $sizes = wp_get_registered_image_subsizes();
    $labels = [];

    foreach ($sizes as $key => $props) {
        $labels[] = sprintf(
            '%s (%s &times; %s)',
            $key,
            $props['width'],
            $props['height']
        );
    }

    $field['choices'] = array_combine(
        array_keys($sizes),
        $labels
    );

    $field['choices']['custom'] = __('Custom', 'pedalcms');

    return $field;
}

/**
 * Removes search filters choices that correspond to disabled taxonomies.
 *
 * Called on filter: `acf/load_field/name=search_filters`
 *
 * Because the search filter fields are all part of field groups, they all
 * share the name `search_filters` and this will operate on all of them.
 *
 * @param array $field The ACF field config.
 * @return array The filtered field config.
 */
function choices_search_filters(array $field): array {
    $choices = [];
    $tax_filters_map = Plugin::get_tax_filters_map();

    foreach ($field['choices'] as $filter => $label) {
        if (array_key_exists($filter, $tax_filters_map)) {
            if (taxonomy_exists($tax_filters_map[$filter])) {
                $choices[$filter] = $label;
            }
        } else {
            $choices[$filter] = $label;
        }
    }

    $field['choices'] = $choices;

    return $field;
}

/**
 * Adds the list of public registered post types (except attachment) to the choices.
 *
 * Called on filter: `acf/load_field/name=post_type`
 *
 * @param array $field The ACF field config.
 * @return array The filtered field config.
 */
function choices_post_type(array $field): array {
    $post_types = get_post_types(
        ['public' => true],
        'objects'
    );

    $choices['none'] = 'None';

    foreach ($post_types as $post_type) {
        $choices[$post_type->name] = sprintf(
            '%s (%s)',
            $post_type->label,
            $post_type->name
        );
    }

    unset($choices['attachment']);

    $field['choices'] = $choices;

    return $field;
}


function prepare_taxonomy_field($field) {
    if (!in_array($field['taxonomy'], Plugin::taxonomies(false))) {
        return $field;
    }

    $tax = str_replace('pdl_', '', $field['taxonomy']);
    $enabled = Plugin::get_option($tax . '_enable');

    /* 
     * Boolean false is returned if the option was not found. Check for that 
     * before disabling this field. 
     */
    if ($enabled !== false && !$enabled) {
        return false;
    }

    return $field;
}


function prepare_department($field) {
    if (!prepare_taxonomy_field($field)) {
        return false;
    }

    if (!Department::depends_on_college()) {
        $field['type'] = 'taxonomy';
    }

    if ($field['type'] === 'select') {
        if ($field['value']) {
            $term = get_term($field['value']);
            $field['choices'][$term->term_id] = $term->name;
        }
    }

    return $field;
}


/**
 * Creates the `pdl_flush_rules` transient when saving the plugin settings page.
 *
 * Called on action: `acf/save_post`
 *
 * @param int|string $post_id The post id of the
 * @return void
 */
function save_options($post_id) {
    if ($post_id === 'options') {
        if ($_GET['page'] === Plugin::$options_page_slug) {
            set_transient('pdl_flush_rules', true);
        }
    }
}

/**
 * Flushes the rewrite rules when `pdl_flush_rules` transient is present.
 *
 * Called on action: `admin_init`
 *
 * @return void
 */
function maybe_flush_rules() {
    if (delete_transient('pdl_flush_rules')) {
        flush_rewrite_rules();
    }
}
