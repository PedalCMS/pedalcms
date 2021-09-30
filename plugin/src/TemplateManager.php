<?php

namespace InvisibleUs\Programs;

/**
 * Template Manager for handling our template system.
 * 
 * @version 0.1.0
 * @package NVISPrograms
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
     *
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

    public function __construct(string $base_path, string $theme_folder, array $templates = []) {
        self::$base_path = $base_path;
        self::$theme_folder = $theme_folder;

        if ($templates) {
            $this->registerTemplates($templates);
        }

        return $this;
    }

    /**
     * Register Templates
     *
     * @param array $templates The list of templates to render.
     * @return void
     */
    public function registerTemplates(array $templates) {
        $this->templates = $templates;
    }

    /**
     * Maybe Use Template
     *
     * Used to filter template_include. Should be fired as late as possible.
     *
     * @param string $current_template The current template based on WP's template hierarchy.
     * @return string
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
     * Locate Template
     *
     * @param string $template
     * @return string
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
     * Load Template
     *
     * @param string $template
     * @param array $data
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
