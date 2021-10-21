<?php

namespace InvisibleUs\Programs;

/**
 * Handles all functionality related to our extended template system.
 *
 * @version 0.1.0
 * @package NVISPrograms
 * @subpackage StandardLib
 * @since 0.1.0
 */
class TemplateManager {
    /**
     * Base path of the plugin templates.
     *
     * @var string
     */
    private static $base_path = '';

    /**
     * The folder to look for templates in the theme.
     *
     * @var string
     */
    private static $theme_folder = '';

    /**
     * An array of associative arrays that match a set of callbacks
     * with templates to render.
     *
     * Example:
     * ```
     *    $templates = [
     *      [
     *        'name' => 'single-career',
     *        'callback' => 'is_singular',
     *        'args' => ['nvis_career']
     *      ]
     *    ];
     * ```
     *
     * @var array The list of registered templates.
     */
    private $templates = [];

    /**
     * Constructor
     *
     * @param string $base_path The root templates folder.
     * @param string $theme_folder The folder in the theme to search for template overrides.
     * @param array $templates A list of templates to register.
     */
    public function __construct(string $base_path, string $theme_folder, array $templates = []) {
        self::$base_path = $base_path;
        self::$theme_folder = $theme_folder;

        if ($templates) {
            // TODO: Fix method name casing to match project standard.
            $this->register_templates($templates);
        }

        return $this;
    }

    /**
     * Registers a given list of templates.
     *
     * @param array $templates The list of templates to render.
     * @return void
     */
    public function register_templates(array $templates) {
        $this->templates = $templates;
    }

    /**
     * Determines whether or not to override the current WordPress template.
     *
     * Used to filter template_include. Should be fired as late as possible.
     *
     * @param string $current_template The current template based on WP's template hierarchy.
     * @return string The filtered template path.
     */
    public function maybe_use_template(string $current_template): string {
        foreach ($this->templates as $template) {
            if (call_user_func($template['callback'], ...$template['args'])) {
                return $this->locate_template($template['name']);
            }
        }

        return $current_template;
    }

    /**
     * Custom version of locate_template checks a theme subdir and our templates folder.
     *
     * @param string $template The name of the template to locate.
     * @return string The full path of the located template.
     */
    public static function locate_template(string $template): string {
        if (!self::$theme_folder) {
            // TODO: Error handling.
            return false;
        }

        $template = trim($template, "./ \n\r\t\v\0");

        $pattern = '%s/%s.php';
        $theme_tmpl = sprintf($pattern, self::$theme_folder, $template);
        $theme_tmpl = locate_template($theme_tmpl);

        if ($theme_tmpl) {
            // Note: theme templates will not get filtered.
            return $theme_tmpl;
        }

        /**
         * Filters the value of an existing option before it is retrieved.
         *
         * @since 0.1.0
         *
         * @param string  $template_path The full path to the template.
         * @param string $name The template name.
         */
        return apply_filters(
            'nvis_prog/locate_template',
            sprintf($pattern, self::$base_path, $template),
            $template
        );
    }

    /**
     * Outputs a template.
     *
     * @param string $template The requested template file. Can include subdir.
     * @param array $data Data to pass to the requested template.
     * @return void
     */
    public static function load_template(string $template, array $args = []) {
        $path = TemplateManager::locate_template($template);

        if (file_exists($path)) {
            include $path;
        } else {
            // TODO: Error handling
        }
    }
}
