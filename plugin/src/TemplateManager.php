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
     *    $templates = [
     *      [
     *        'name' => 'single-career',
     *        'callback' => 'is_singular',
     *        'args' => ['nvis_career']
     *      ]
     *    ];
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
            $this->registerTemplates($templates);
        }

        return $this;
    }

    /**
     * Registers a given list of templates.
     *
     * @param array $templates The list of templates to render.
     * @return void
     */
    public function registerTemplates(array $templates) {
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
    public function maybeUseTemplate(string $current_template): string {
        foreach ($this->templates as $template) {
            if (call_user_func($template['callback'], ...$template['args'])) {
                return $this->locateTemplate($template['name']);
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
    public static function locateTemplate(string $template): string {
        if (!self::$theme_folder) {
            // TODO: Error handling.
            return false;
        }

        $pattern = '%s/%s.php';
        $theme_tmpl = sprintf($pattern, self::$theme_folder, $template);
        $theme_tmpl = locate_template($theme_tmpl);

        if ($theme_tmpl) {
            // Note: theme templates will not get filtered.
            return $theme_tmpl;
        }
        // TODO: Doc block this hook. For an example, see:
        //  https://developer.wordpress.org/reference/functions/get_template_part/
        return apply_filters(
            'nvis_programs/locate_template',
            sprintf($pattern, self::$base_path, $template)
        );
    }

    /**
     * Outputs a template.
     *
     * @param string $template The requested template file. Can include subdir.
     * @param array $data Data to pass to the requested template.
     * @return void
     */
    public static function loadTemplate(string $template, array $data = []) {
        $path = TemplateManager::locateTemplate($template);

        if (file_exists($path)) {
            include $path;
        } else {
            // TODO: Error handling
        }
    }
}
