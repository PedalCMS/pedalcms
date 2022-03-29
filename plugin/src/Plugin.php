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

    public static $labels = [];

    /**
     * Stores ACF field group config
     *
     * @var array
     */
    public static $field_groups = [];

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

    public static function install() {
        self::register_content_model();
        self::install_capabilities();
        flush_rewrite_rules();
    }

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
     * Handles configuration of the ACF field group.
     *
     * @return void
     */
    public static function setup_field_group(): void {
        $field_group = [
            'key'      => 'group_6113a9e72073e',
            'title'    => __('Program Pages Settings', 'nvis-program-pages'),
            'location' => [
                [
                    [
                        'param'    => 'options_page',
                        'operator' => '==',
                        'value'    => 'nvis-program-pages-settings',
                    ],
                ],
            ],
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen'        => '',
            'active'                => true,
            'description'           => '',
            'fields'                => [
                [
                    'key'               => 'field_6197ebda851fd',
                    'label'             => __('Presentation Mode', 'nvis-program-pages'),
                    'name'              => 'nvis_presentation_mode',
                    'type'              => 'radio',
                    'instructions'      => __('Choose the amount of CSS you want output.', 'nvis-program-pages'),
                    'wrapper'           => [
                        'width' => '',
                        'class' => '',
                        'id'    => '',
                    ],
                    'choices' => [
                        'none' => __('Ghost — Don\'t style anything. No CSS will be loaded.', 'nvis-program-pages'),
                        'base' => __('Stealth — Only basic styling to handle layout. Blends in with current theme as much as possible.', 'nvis-program-pages'),
                        'full' => __('Tuxedo — A more refined and opinionated look. Recommended for most sites.', 'nvis-program-pages'),
                    ],
                    'default_value'     => 'full',
                    'layout'            => 'vertical',
                    'return_format'     => 'value',
                ],
                [
                    'key'          => 'field_6113aaf181bb3',
                    'label'        => __('Request Info URL', 'nvis-program-pages'),
                    'name'         => 'nvis_url_request_info',
                    'type'         => 'url',
                    'instructions' => __('Enter a URL pattern to create unique request info URLs for each program. You can use the following tags: {$program_guid} {$program_slug}', 'nvis-program-pages'),
                    'placeholder'  => '',
                ],
                [
                    'key'          => 'field_61156396f5e83',
                    'label'        => __('Apply Now URL', 'nvis-program-pages'),
                    'name'         => 'nvis_url_apply_now',
                    'type'         => 'url',
                    'instructions' => __('Enter a URL pattern to create unique apply now URLs for each program. You can use the following tags: {$program_guid} {$program_slug}', 'nvis-program-pages'),
                    'placeholder'  => '',
                ],
                [
                    'key'          => 'field_611563eef5e84',
                    'label'        => __('Contact URL', 'nvis-program-pages'),
                    'name'         => 'nvis_url_contact',
                    'type'         => 'url',
                    'instructions' => __('Enter a URL pattern to create unique contact URLs for each program. You can use the following tags: {$program_guid} {$program_slug}', 'nvis-program-pages'),
                    'placeholder'  => '',
                ],
                [
                    'key'          => 'field_612e8f1e1b6a7',
                    'label'        => __('Course Registration Search URL', 'nvis-program-pages'),
                    'name'         => 'nvis_course_url_reg_search',
                    'type'         => 'url',
                    'instructions' => __('Enter a URL pattern to create unique "Search Sections" URLs for each course. You can use the following tag: {$course_reg_key}', 'nvis-program-pages'),
                    'placeholder'  => '',
                ],
                [
                    'key'          => 'field_613a6ffacb272',
                    'label'        => __('Program Contact Label', 'nvis-program-pages'),
                    'name'         => 'nvis_program_contact_label',
                    'type'         => 'text',
                    'instructions' => __('This is the label that Appears above the primary contact on each Program page.', 'nvis-program-pages'),
                    'placeholder'  => _x('Program Contact', 'program contact label field placeholder', 'nvis-program-pages'),
                ],
                [
                    'key'          => 'field_61156b547d402',
                    'label'        => __('Application Deadlines', 'nvis-program-pages'),
                    'name'         => 'nvis_application_deadlines',
                    'type'         => 'repeater',
                    'instructions' => '',
                    'collapsed'    => 'field_61156b777d403',
                    'layout'       => 'block',
                    'button_label' => _x('Add Deadline', 'New deadline button text', 'nvis-program-pages'),
                    'sub_fields'   => [
                        [
                            'key'          => 'field_61156b777d403',
                            'label'        => __('Deadline Label', 'nvis-program-pages'),
                            'name'         => 'deadline_label',
                            'type'         => 'text',
                            'instructions' => '',
                            'required'     => 1,
                            'placeholder'  => _x('Fall, Spring, etc.', 'deadline label field placeholder', 'nvis-program-pages'),
                            'maxlength'    => '',
                        ],
                        [
                            'key'          => 'field_61156bbe7d404',
                            'label'        => __('Deadline Info', 'nvis-program-pages'),
                            'name'         => 'deadline_info',
                            'type'         => 'text',
                            'instructions' => '',
                            'placeholder'  => _x('e.g. June 24th', 'deadline info field placeholder', 'nvis-program-pages'),
                            'maxlength'    => '',
                        ],
                    ],
                ],
                [
                    'key'           => 'field_6171cbf69ba0a',
                    'label'         => __('Enable Block Editor for Personnel', 'nvis-program-pages'),
                    'name'          => 'nvis_enable_block_editor_personnel',
                    'type'          => 'true_false',
                    'instructions'  => __('Use the block editor to edit personnel profiles.', 'nvis-program-pages'),
                    'required'      => 0,
                    'default_value' => 1,
                    'ui'            => 1,
                ],
                [
                    'key'           => 'field_617308be36302',
                    'label'         => __('Main Content Wrapper Tag', 'nvis-program-pages'),
                    'name'          => 'nvis_main_content_wrapper_tag',
                    'type'          => 'select',
                    'instructions'  => __('Switch to "main" to fix accessibility issues with some themes.', 'nvis-program-pages'),
                    'default_value' => 'div',
                    'return_format' => 'value',
                    'choices'       => [
                        'div'  => 'div',
                        'main' => 'main',
                    ],
                ],
                [
                    'key'          => 'field_61e1ea5a45930',
                    'label'        => __('Featured Image Size', 'nvis-program-pages'),
                    'name'         => 'nvis_image_size_single',
                    'type'         => 'select',
                    'instructions' => '',
                    'choices'      => [
                    ],
                    'default_value' => false,
                    'allow_null'    => 1,
                    'multiple'      => 0,
                    'ui'            => 1,
                    'ajax'          => 1,
                    'return_format' => 'value',
                    'placeholder'   => '',
                ],
                [
                    'key'           => 'field_61e1deb86546b',
                    'label'         => __('Deafult Program Image', 'nvis-program-pages'),
                    'name'          => 'nvis_image_fallback_program',
                    'type'          => 'image',
                    'instructions'  => __('The fallback featured image for Programs that don\'t have one.', 'nvis-program-pages'),
                    'return_format' => 'id',
                    'preview_size'  => 'medium',
                    'library'       => 'all',
                ],
            ]
        ];

        $subpages = Program::subpage_manager()->get_builtin_subpages(false);
        $def_vals = [];

        $enable_subpages = [
            'key'           => 'field_6231f0679deb5',
            'label'         => __('Enable Program Subpages', 'nvis-program-pages'),
            'name'          => 'nvis_enable_subpages_nvis_program',
            'type'          => 'checkbox',
            'instructions'  => '',
            'choices'       => $subpages,
            'allow_custom'  => 0,
            'default_value' => array_pad($def_vals, count($subpages), 1),
            'layout'        => 'vertical',
            'toggle'        => 1,
            'return_format' => 'value',
            'save_custom'   => 0,
        ];

        array_unshift($field_group['fields'], $enable_subpages);

        self::$field_groups[] = $field_group;

        return;
    }

    public static function get_field_group(): array {
        return static::$field_groups[0] ?? [];
    }

    private static function setup_options_page() {
        self::$options_page = [
            'page_title'  => __('Program Pages Settings', 'nvis-program-pages'),
            'menu_title'  => _x('Program Pages', 'menu item title', 'nvis-program-pages'),
            'menu_slug'   => 'nvis-program-pages-settings',
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
            'no_posts_found'         => __('No posts found.', 'nvis-program-pages'),
            'no_courses_found'       => __('No courses were found.', 'nvis-program-pages'),
            'no_one_found'           => __('No one was found.', 'nvis-program-pages'),
            'no_programs_found'      => __('No programs were found.', 'nvis-program-pages'),
            'college'                => __('College', 'nvis-program-pages'),
            'instruction_mode'       => __('Instruction Mode', 'nvis-program-pages'),
            'prerequisites'          => __('Prerequisites', 'nvis-program-pages'),
            'person_category'        => __('Category', 'nvis-program-pages'),
            'program_type'           => __('Program Type', 'nvis-program-pages'),
            'session'                => __('Term', 'nvis-program-pages'),
            'subject'                => __('Subject', 'nvis-program-pages'),
            'department'             => __('Department', 'nvis-program-pages'),
            'yes'                    => __('Yes', 'nvis-program-pages'),
            'no'                     => __('No', 'nvis-program-pages'),
            'phone'                  => _x('Phone', 'noun', 'nvis-program-pages'),
            'email'                  => _x('Email', 'noun', 'nvis-program-pages'),
            'office'                 => __('Office', 'nvis-program-pages'),
            'single_post'            => __('post', 'nvis-program-pages'),
            'posts'                  => __('posts', 'nvis-program-pages'),
            'filter'                 => __('Filter', 'nvis-program-pages'),
            'show'                   => __('Show', 'nvis-program-pages'),
            'hide'                   => __('Hide', 'nvis-program-pages'),
            'more_filters'           => __('More Filters', 'nvis-program-pages'),
            'apply_filters'          => __('Search', 'nvis-program-pages'),
            'reset_filters'          => __('Reset Filters', 'nvis-program-pages'),
            'missing_filters_data'   => __('Missing data to render filters.', 'nvis-program-pages'),
            /* translators: The argument is the name of the filter. It will be translated separately. */
            'missing_filter_data'    => __('Missing data to render %s filter', 'nvis-program-pages'),
            'filtered_results'       => __('Filtered Results', 'nvis-program-pages'),
            'showing'                => __('Showing', 'nvis-program-pages'),
            /* translators: Number of results (e.g. 'Showing 1-10 of 120 posts'). Note: the last argument will be translated separately.  */
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
            'contact'                => __('Contact', 'nvis-program-pages'),
            'course'                 => __('Course', 'nvis-program-pages'),
            'featured'               => __('Featured', 'nvis-program-pages'),
            'read_more'              => __('Read More', 'nvis-program-pages'),
            'show_all_posts'         => __('Show All Posts', 'nvis-program-pages'),
            'program_details'        => __('Program Details', 'nvis-program-pages'),
            'apply_now'              => __('Apply Now', 'nvis-program-pages'),
            'request_info'           => __('Request Info', 'nvis-program-pages'),
            'estimated_cost'         => __('Estimated Cost', 'nvis-program-pages'),
            'register'               => __('Register', 'nvis-program-pages'),
            'course_info'            => __('View Course', 'nvis-program-pages'),
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
        Course::get_instance()->register();
        FAQ::get_instance()->register();
        Person::get_instance()->register();
        ProgramType::get_instance()->register();
        College::get_instance()->register();
        InstructionMode::get_instance()->register();
        Subject::get_instance()->register();
        Session::get_instance()->register();
        PersonCategory::get_instance()->register();
        Department::get_instance()->register();
        FAQCategory::get_instance()->register();

        return;
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
        $value = get_field('nvis_' . $option, 'option');

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
