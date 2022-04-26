<?php

namespace InvisibleUs\Programs;

/**
 * Handles all global settings and setup.
 *
 * @package NVISPrograms
 * @since 0.1.0
 */
class Plugin {
    /**
     * Slug style name of the plugin. Should match folder name.
     *
     * @var string
     */
    public static $name = 'nvis-program-pages';

    /**
     * Absolute path of the plugin root.
     *
     * @var string
     */
    public static $path = '';

    /**
     * URL of the plugin root.
     *
     * @var string
     */
    public static $url = '';

    /**
     * Template folder name.
     *
     * @var string
     */
    public static $template_path = '/templates';

    /**
     * Whether the plugin has already been initialized.
     *
     * @var boolean
     */
    private static $_init = false;

    /**
     * Config for reistering ACF options page.
     *
     * @var array
     */
    public static $options_page;

    public static $options_page_slug;

    public static $labels = [];

    /**
     * Stores ACF field group config
     *
     * @var array
     */
    public static $field_groups = [];

    /**
     * Stores the list of post types available in this plugin.
     *
     * @var array
     */
    private static $post_types = [];

    /**
     * Stores the list of post types currently enabled and registered by this plugin.
     *
     * @var array
     */
    private static $post_types_enabled = [];

    /**
     * Stores the list of taxonomies available in this plugin.
     *
     * @var array
     */
    private static $taxonomies = [];

    /**
     * Stores the list of taxonomies currently enabled and registered by this plugin.
     *
     * @var array
     */
    private static $taxonomies_enabled = [];

    /**
     * Kicks off the whole plugin setup.
     */
    public function __construct() {
        if (self::$_init) {
            return;
        }

        self::$path = dirname(__DIR__);
        self::$url = plugins_url(self::$name);
        self::$template_path = self::$path . self::$template_path;

        add_action('init', [self::class, 'plugin_init'], 0);

        self::$_init = true;
    }

    /**
     * Handles install tasks for the plugin.
     *
     * @return void
     */
    public static function install() {
        self::register_content_model();
        self::install_capabilities();
        flush_rewrite_rules();
    }

    /**
     * Adds capabilities for the entire content model to the Administrator role. 
     *
     * @return void
     */
    public static function install_capabilities() {
        $role = get_role('administrator');
        $post_type_args = [
            (object) Program::get_instance()->args,
            (object) Person::get_instance()->args,
            (object) Course::get_instance()->args,
            (object) FAQ::get_instance()->args,
        ];

        foreach ($post_type_args as $args) {
            $args->capabilities = [];

            $caps = get_post_type_capabilities($args);

            foreach ($caps as $cap) {
                $role->add_cap($cap);
            }
        }
    }

    /**
     * Performs some plugin setup.
     *
     * Called on action: init
     *
     * @return void
     */
    public static function plugin_init(): void {
        load_plugin_textdomain(
            self::$name,
            false,
            self::$name . '/languages/'
        );

        // NOTE: This has to be done before init_field_group.
        Program::setup_subpage_manager();

        self::setup_options_page();
        self::setup_field_group();
        self::setup_labels();

        self::register_content_model();
        self::register_custom_blocks();
        self::setup_template_manager();
    }

    /**
     * Loads configuration of the ACF field group.
     *
     * @return void
     */
    public static function setup_field_group(): void {
        require_once self::$path . '/src/field-group-plugin.php';

        self::$field_groups[] = $field_group;

        return;
    }

    public static function get_field_group(): array {
        return static::$field_groups[0] ?? [];
    }

    /**
     * Sets up the options page config.
     *
     * @return void
     */
    private static function setup_options_page() {
        self::$options_page_slug = 'nvis-program-pages-settings';

        self::$options_page = [
            'page_title'  => __('Program Pages Settings', 'nvis-program-pages'),
            'menu_title'  => _x('Program Pages', 'menu item title', 'nvis-program-pages'),
            'menu_slug'   => self::$options_page_slug,
            'capability'  => 'manage_options',
            'parent_slug' => 'options-general.php',
            'position'    => 7,
            'redirect'    => false,
        ];
    }

    /**
     * Initializes the label repository.
     *
     * @return void
     */
    private static function setup_labels() {
        self::$labels = [
            'more_details'           => __('More Details', 'nvis-program-pages'),
            'no_one_found'           => __('No one was found.', 'nvis-program-pages'),
            'no_programs_found'      => __('No programs were found.', 'nvis-program-pages'),
            'prerequisites'          => __('Prerequisites', 'nvis-program-pages'),
            'yes'                    => __('Yes', 'nvis-program-pages'),
            'no'                     => __('No', 'nvis-program-pages'),
            'phone'                  => _x('Phone', 'noun', 'nvis-program-pages'),
            'email'                  => _x('Email', 'noun', 'nvis-program-pages'),
            'office'                 => __('Office', 'nvis-program-pages'),
            'filter'                 => __('Filter', 'nvis-program-pages'),
            'show'                   => __('Show', 'nvis-program-pages'),
            'hide'                   => __('Hide', 'nvis-program-pages'),
            'more_filters'           => __('More Filters', 'nvis-program-pages'),
            'apply_filters'          => __('Search', 'nvis-program-pages'),
            'reset_filters'          => __('Reset Filters', 'nvis-program-pages'),
            'missing_filters_data'   => __('Missing data to render filters.', 'nvis-program-pages'),
            /* translators: The placeholder is the name of the filter. It will be translated separately. */
            'missing_filter_data'    => __('Missing data to render %s filter', 'nvis-program-pages'),
            'filtered_results'       => __('Filtered Results', 'nvis-program-pages'),
            'showing'                => __('Showing', 'nvis-program-pages'),
            /* translators: Number of results (e.g. 'Showing 1-10 of 120 posts'). Note: the last placeholder is the name of the post_type.  */
            'showing_of'             => __('Showing %1$s–%2$s of %3$s %4$s.', 'nvis-program-pages'),
            'keyword'                => __('Keyword', 'nvis-program-pages'),
            'none_selected_prefix'   => __('Any ', 'nvis-program-pages'),
            'credit'                 => __('credit', 'nvis-program-pages'),
            'credits'                => __('credits', 'nvis-program-pages'),
            'offered_in'             => __('Offered in', 'nvis-program-pages'),
            'instructors'            => __('Instructors', 'nvis-program-pages'),
            'courses_taught'         => __('Courses Taught', 'nvis-program-pages'),
            'program_subnav'         => __('Program Subnav', 'nvis-program-pages'),
            'about_program'          => __('About this Program', 'nvis-program-pages'),
            'application_deadlines'  => __('Application Deadlines', 'nvis-program-pages'),
            'program_contact'        => __('Program Contact', 'nvis-program-pages'),
            'contact_action'         => __('Contact', 'nvis-program-pages'),
            'featured'               => __('Featured', 'nvis-program-pages'),
            'read_more'              => __('Read More', 'nvis-program-pages'),
            'show_all_posts'         => __('Show All Posts', 'nvis-program-pages'),
            'program_details'        => __('Program Details', 'nvis-program-pages'),
            'apply_now_action'       => __('Apply Now', 'nvis-program-pages'),
            'request_info_action'    => __('Request Info', 'nvis-program-pages'),
            'estimated_cost'         => __('Estimated Cost', 'nvis-program-pages'),
            'register_action'        => __('Register', 'nvis-program-pages'),
            'back_to_top'            => __('Back to Top', 'nvis-program-pages'),
        ];
    }

    /**
     * Registers all the custom post types and custom taxonomies.
     *
     * @return void
     */
    public static function register_content_model(): void {
        Program::get_instance()->register();
        self::$post_types[] = Program::POST_TYPE;
        self::$post_types_enabled[] = Program::POST_TYPE;

        self::$post_types[] = Course::POST_TYPE;
        if (self::get_option('course_enable')) {
            Course::get_instance()->register();
            self::$post_types_enabled[] = Course::POST_TYPE;
        }

        self::$post_types[] = Person::POST_TYPE;
        if (self::get_option('person_enable')) {
            Person::get_instance()->register();
            self::$post_types_enabled[] = Person::POST_TYPE;
        }

        self::$post_types[] = FAQ::POST_TYPE;
        $enabled_subpages = Program::subpage_manager()->get_enabled_subpages();

        if (is_array($enabled_subpages) && in_array('faqs', $enabled_subpages)) {
            FAQ::get_instance()->register();
            self::$post_types_enabled[] = FAQ::POST_TYPE;
        }

        self::$taxonomies[] = ProgramType::TAXONOMY;
        if (self::get_option('program_type_enable')) {
            ProgramType::get_instance()->register();
            self::$taxonomies_enabled[] = ProgramType::TAXONOMY;
        }

        self::$taxonomies[] = College::TAXONOMY;
        if (self::get_option('college_enable')) {
            College::get_instance()->register();
            self::$taxonomies_enabled[] = College::TAXONOMY;
        }

        self::$taxonomies[] = InstructionMode::TAXONOMY;
        if (self::get_option('instruct_mode_enable')) {
            InstructionMode::get_instance()->register();
            self::$taxonomies_enabled[] = InstructionMode::TAXONOMY;
        }

        self::$taxonomies[] = Subject::TAXONOMY;
        if (self::get_option('subject_enable')) {
            Subject::get_instance()->register();
            self::$taxonomies_enabled[] = Subject::TAXONOMY;
        }

        self::$taxonomies[] = Session::TAXONOMY;
        if (self::get_option('session_enable')) {
            Session::get_instance()->register();
            self::$taxonomies_enabled[] = Session::TAXONOMY;
        }

        self::$taxonomies[] = PersonCategory::TAXONOMY;
        if (self::get_option('person_cat_enable')) {
            PersonCategory::get_instance()->register();
            self::$taxonomies_enabled[] = PersonCategory::TAXONOMY;
        }

        self::$taxonomies[] = Department::TAXONOMY;
        if (self::get_option('department_enable')) {
            Department::get_instance()->register();
            self::$taxonomies_enabled[] = Department::TAXONOMY;
        }

        self::$taxonomies[] = FAQCategory::TAXONOMY;
        if (self::get_option('faq_cat_enable')) {
            FAQCategory::get_instance()->register();
            self::$taxonomies_enabled[] = FAQCategory::TAXONOMY;
        }

        return;
    }

    /**
     * Gets the list of post types available or registered by this plugin.
     *
     * @since 0.1.0
     *
     * @param bool $enabled_only Whether or not to only return enabled post types.
     * @return array An array of post type keys.
     */
    public static function post_types(bool $enabled_only = true): array {
        if ($enabled_only) {
            return self::$post_types_enabled;
        }

        return self::$post_types;
    }

    /**
     * Gets the list of taxonomies available or registered by this plugin.
     *
     * @since 0.1.0
     *
     * @param bool $enabled_only Whether or not to only return enabled taxonomies.
     * @return array An array of taxonomy keys.
     */
    public static function taxonomies(bool $enabled_only = true): array {
        if ($enabled_only) {
            return self::$taxonomies_enabled;
        }

        return self::$taxonomies;
    }

    /**
     * Returns an associative array of taxonomies indexed by their search filter name.
     *
     * @return array The search filter to taxonomy map.
     */
    public static function get_tax_filters_map(): array {
        static $map = null;

        if (!$map) {
            $filters = array_map(
                function($a) {
                    return str_replace(
                        ['nvis_', '_'],
                        ['', '-'],
                        $a
                    );
                },
                self::$taxonomies
            );

            $map = array_combine($filters, self::$taxonomies);
        }

        return $map;
    }

    /**
     * Registers custom Gutenberg blocks for the entire plugin.
     *
     * @return void
     */
    public static function register_custom_blocks(): void {
        if (!Person::is_block_editor_enabled()) {
            return;
        }

        new JobTitleBlock();
        new ContactInfoBlock();

        return;
    }

    /**
     * Creates and configures the template manager.
     *
     * @return void
     */
    public static function setup_template_manager(): void {
        $person_template = 'single-person';

        if (!Person::is_block_editor_enabled()) {
            $person_template .= '-classic';
        }

        $templates = [
            [
                'name'     => 'single-program',
                'callback' => 'is_singular',
                'args'     => [Program::POST_TYPE]
            ],
            [
                'name'     => 'archive-program',
                'callback' => 'is_post_type_archive',
                'args'     => [Program::POST_TYPE]
            ],
            [
                'name'     => 'single-course',
                'callback' => 'is_singular',
                'args'     => [Course::POST_TYPE]
            ],
            [
                'name'     => 'archive-course',
                'callback' => 'is_post_type_archive',
                'args'     => [Course::POST_TYPE]
            ],
            [
                'name'     => 'archive-person',
                'callback' => 'is_post_type_archive',
                'args'     => [Person::POST_TYPE]
            ],
            [
                'name'     => $person_template,
                'callback' => 'is_singular',
                'args'     => [Person::POST_TYPE]
            ]
        ];

        $NVIS_TemplateManager = new TemplateManager(
            self::$template_path,
            self::$name,
            $templates
        );

        add_filter('template_include', [$NVIS_TemplateManager, 'maybe_use_template'], PHP_INT_MAX);

        return;
    }

    /**
     * Returns a label from the plugin wide registry. 
     *
     * @param string $label_key The key of the label to retrieve.
     * @return string The requested label on success, "label not found" message on failure.
     */
    public static function get_label(string $label_key): string {
        $label = self::get_option('label_' . $label_key);

        if (!$label) {
            $label = self::$labels[$label_key] ??
                sprintf(
                    /* translators: the argument is the key of the label */
                    __('Label "%s" not found', 'nvis-program-pages'),
                    $label_key
                );
        }

        $label = apply_filters('nvis/get_label', $label, 'programs');

        return $label;
    }

    /**
     * Retrieves a plugin setting.
     *
     * A simple wrapper around ACF get_field that handles prefixing the
     * setting name.
     *
     * @param string $option The name of the setting.
     * @return mixed The value of the setting.
     */
    public static function get_option(string $option) {
        $value = get_option('options_nvis_' . $option);

        /**
         * Filters the value of an option. The last part is the name of the option.
         *
         * @since 0.1
         *
         * @param $value The value of the option.
         */
        return apply_filters("nvis/programs/options/{$option}", $value);
    }
}
