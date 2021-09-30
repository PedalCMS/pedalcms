<?php

namespace InvisibleUs\Programs;

/**
 * Handles all functionality related to Program Subpages.
 * 
 * @version 0.1.0
 * @package NVISPrograms
 * @since 0.1.0
 */
class ProgramSubpageManager {
    /**
     * The query var to register.
     *
     * @var string
     */
    private const query_var = 'nvis_subpage';

    /**
     * List of subpages as a slug/title hash.
     *
     * @var array
     */
    private static $subpages = [];

    /**
     * Constructor
     */
    public function __construct() {
        self::$subpages = [
            (object) [
                'slug'  => 'index',
                'title' => 'Overview'
            ],
            new CareersProgramSubpage(),
            new CoursesProgramSubpage(),
            new FacultyStaffProgramSubpage(),
            new CostProgramSubpage(),
            new ApplyProgramSubpage(),
            new FAQProgramSubpage(),
            new NewsProgramSubpage()
        ];

        return;
    }

    public function init(): void {
        add_action('wp', [self::class, 'maybe_override_rel_canonical']);
        add_filter('rewrite_rules_array', [self::class, 'insert_rules']);
        add_filter('query_vars', [self::class, 'add_query_var']);

        do_action('nvis/afer_program_subpages_setup');

        return;
    }

    /**
     * Returns the list of subpages.
     *
     * @param bool $with_index Whether or not to include the index.
     * @param string $return_type Can be 'hash' or 'objects'.
     * @return array
     */
    public static function get_subpages(bool $with_index = true, string $return_type = 'hash'): array {
        if ($return_type === 'hash') {
            $hash = array_combine(
                wp_list_pluck(self::$subpages, 'slug'),
                wp_list_pluck(self::$subpages, 'title')
            );

            if (!$with_index) {
                array_shift($hash);
            }

            return $hash;
        }

        if ($return_type !== 'objects') {
            // TODO: Trigger error.
            return [];
        }

        return self::$subpages;
    }

    /**
     * Register our custom query variable.
     *
     * @param array $vars The existing query vars.
     * @return array The resulting query vars after we add ours.
     */
    public static function add_query_var(array $vars): array {
        $vars[] = self::query_var;

        return $vars;
    }

    /**
     * Adds rewrite rules for programs subpages.
     *
     * @param array $rules The existing rewrite rules.
     * @return array The resulting rewrite rules with ours added.
     */
    public static function insert_rules(array $rules): array {
        $subpage_rules = [];
        // TODO: load program stub dynamically.
        $pretty_pattern = 'program/([^/]+)/%s/?$';
        // TODO: load program CPT name by reference.
        $real_pattern = sprintf(
            'index.php?%s=$matches[1]&%s=',
            Program::POST_TYPE,
            self::query_var
        );

        foreach (self::$subpages as $subpage) {
            if ($subpage->slug !== 'index') {
                $index = sprintf($pretty_pattern, $subpage->slug);
                $subpage_rules[$index] = $real_pattern . $subpage->slug;
            }
        }

        return $subpage_rules + $rules;
    }

    /**
     * Decides whether or not to override the canonical tag.
     *
     * @return void
     */
    public static function maybe_override_rel_canonical(): void {
        // TODO: make program CPT name a reference.
        if (is_singular(Program::POST_TYPE) && self::get_active_subpage() !== 'index') {
            remove_filter('wp_head', 'rel_canonical');
            add_filter('wp_head', [self::class, 'subpage_canonical']);
        }

        return;
    }

    /**
     * Renders a custom canonical link for Program subpages.
     *
     * @return void
     */
    public static function subpage_canonical(): void {
        echo sprintf(
            '<link rel="canonical" href="%s" />',
            self::get_subpage_link(self::get_active_subpage(), false)
        );

        return;
    }

    /**
     * Returns the active subpage by slug.
     *
     * This function should only be called in the context of a single program.
     *
     * @return string The slug of the active subpage.
     */
    public static function get_active_subpage(): string {
        $subpage = get_query_var(self::query_var);

        return $subpage ? $subpage : 'index';
    }

    /**
     * Tests whether the subpage is currently active.
     *
     * @param string $subpage The slug of the page to test.
     * @return boolean
     */
    public static function is_active_subpage(string $subpage): bool {
        return self::get_active_subpage() === $subpage;
    }


    /**
     * Decides whether a particular subpage should be rendered.
     *
     * @param string $subpage
     * @return boolean
     */
    public static function maybe_show_subpage(string $subpage): bool {
        if ($subpage === 'index') {
            return true;
        }

        $enabled = self::get_enabled_subpages();
        $field_safe = str_replace('-', '_', $subpage);

        return
            in_array($subpage, $enabled, true) &&
            (bool) get_field(sprintf('show_%s_section', $field_safe));
    }

    /**
     * Gets the list of currently enabled subpages.
     *
     * @return array List of subpages by slug.
     */
    public static function get_enabled_subpages(): array {
        $enabled = get_field('enable_program_subpages', 'option');

        if (!is_array($enabled)) {
            $enabled = [];
        }

        return $enabled;
    }

    /**
     * Generates a URL for a given subpage.
     *
     * This function should only be called in the context of a single program.
     *
     * @param string $subpage The slug of the subpage.
     * @param boolean $echo Whether or not to output the URL.
     * @return string The subpage URL.
     */
    public static function get_subpage_link(string $subpage, bool $echo = true): string {
        $link = $subpage === 'index' ?
            get_the_permalink() :
            sprintf('%s%s/', get_the_permalink(), $subpage);

        if ($echo) {
            echo $link;
        }

        return $link;
    }

    public static function get_enabled_subpage_fields(): array {
        $fields = [];
        $enabled = self::get_enabled_subpages();

        foreach (self::$subpages as $subpage) {
            if (in_array($subpage->slug, $enabled, true)) {
                $fields = array_merge($fields, $subpage->fields);
            }
        }

        return $fields;
    }
}
