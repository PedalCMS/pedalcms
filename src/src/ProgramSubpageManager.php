<?php

namespace InvisibleUs\Programs;

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
    private $subpages = [
        'index'   => 'Overview',
        'careers' => 'Careers',
        'courses' => 'Courses',
        'faqs'    => 'FAQs',
        'cost'    => 'Cost',
        'apply'   => 'How to Apply',
        'news'    => 'News'
    ];

    /**
     * Constructor
     */
    public function __construct() {
        add_action('wp', [$this, '\maybe_override_rel_canonical']);
        add_filter('rewrite_rules_array', [$this, '\insert_rules']);
        add_filter('query_vars', [$this, '\insert_query_var']);

        return;
    }

    /**
     * Returns the list of subpages.
     *
     * @return array
     */
    public function get_subpages(): array {
        return $this->subpages;
    }

    /**
     * Register our custom query variable.
     *
     * @param array $vars The existing query vars.
     * @return array The resulting query vars after we add ours.
     */
    public function insert_query_var(array $vars): array {
        $vars[] = self::query_var;

        return $vars;
    }

    /**
     * Adds rewrite rules for programs subpages.
     *
     * @param array $rules The existing rewrite rules.
     * @return array The resulting rewrite rules with ours added.
     */
    public function insert_rules(array $rules): array {
        $subpage_rules = [];
        // TODO: load program stub dynamically.
        $pretty_pattern = 'program/([^/]+)/%s/?$';
        // TODO: load program CPT name by reference.
        $real_pattern = 'index.php?nvis_program=$matches[1]&nvis_subpage=';

        foreach ($this->subpages as $slug => $title) {
            $index = sprintf($pretty_pattern, $slug);
            $subpage_rules[$index] = $real_pattern . $slug;
        }

        return $subpage_rules + $rules;
    }

    /**
     * Decides whether or not to override the canonical tag.
     *
     * @return void
     */
    public function maybe_override_rel_canonical(): void {
        // TODO: make program CPT name a reference.
        if (is_singular('nvis_program') && $this->get_active_subpage() !== 'index') {
            remove_filter('wp_head', 'rel_canonical');
            add_filter('wp_head', __NAMESPACE__  . '\subpage_canonical');
        }

        return;
    }

    /**
     * Renders a custom canonical link for Program subpages.
     *
     * @return void
     */
    public function subpage_canonical(): void {
        echo sprintf(
            '<link rel="canonical" href="%s" />',
            $this->get_subpage_link($this->get_active_subpage(), false)
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

        return
            in_array($subpage, $enabled, true) &&
            (bool) get_field(sprintf('show_%s_section', $subpage));
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
    public function get_subpage_link(string $subpage, bool $echo = true): string {
        $link = $subpage === 'index' ?
            get_the_permalink() :
            sprintf('%s%s/', get_the_permalink(), $subpage);

        if ($echo) {
            echo $link;
        }

        return $link;
    }
}
