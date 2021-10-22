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
    public static $options_page = [
        'page_title'  => 'Program Pages Settings',
        'menu_title'  => 'Program Pages',
        'menu_slug'   => 'nvis-program-pages-settings',
        'capability'  => 'manage_options',
        'parent_slug' => 'options-general.php',
        'position'    => 7,
        'redirect'    => false,
    ];

    /** Config for populating Plugin options page. */
    public static $field_groups = [
        [
            'key'      => 'group_6113a9e72073e',
            'title'    => 'Program Pages Settings',
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
                    'key'          => 'field_6113aaf181bb3',
                    'label'        => 'Request Info URL',
                    'name'         => 'nvis_url_request_info',
                    'type'         => 'url',
                    'instructions' => 'Enter a URL pattern to create unique request info URLs for each program. You can use the following tags: {$program_guid} {$program_slug}',
                    'placeholder'  => '',
                ],
                [
                    'key'          => 'field_61156396f5e83',
                    'label'        => 'Apply Now URL',
                    'name'         => 'nvis_url_apply_now',
                    'type'         => 'url',
                    'instructions' => 'Enter a URL pattern to create unique apply now URLs for each program. You can use the following tags: {$program_guid} {$program_slug}',
                    'placeholder'  => '',
                ],
                [
                    'key'          => 'field_611563eef5e84',
                    'label'        => 'Contact URL',
                    'name'         => 'nvis_url_contact',
                    'type'         => 'url',
                    'instructions' => 'Enter a URL pattern to create unique contact URLs for each program. You can use the following tags: {$program_guid} {$program_slug}',
                    'placeholder'  => '',
                ],
                [
                    'key'          => 'field_612e8f1e1b6a7',
                    'label'        => 'Course Registration Search URL',
                    'name'         => 'nvis_course_url_reg_search',
                    'type'         => 'url',
                    'instructions' => 'Enter a URL pattern to create unique "Search Sections" URLs for each course. You can use the following tag: {$course_reg_key}',
                    'placeholder'  => '',
                ],
                [
                    'key'          => 'field_613a6ffacb272',
                    'label'        => 'Program Contact Label',
                    'name'         => 'nvis_program_contact_label',
                    'type'         => 'text',
                    'instructions' => 'This is the label that Appears above the primary contact on each Program page.',
                    'placeholder'  => 'Program Contact',
                ],
                [
                    'key'          => 'field_61156b547d402',
                    'label'        => 'Application Deadlines',
                    'name'         => 'nvis_application_deadlines',
                    'type'         => 'repeater',
                    'instructions' => '',
                    'collapsed'    => 'field_61156b777d403',
                    'layout'       => 'block',
                    'button_label' => 'Add Deadline',
                    'sub_fields'   => [
                        [
                            'key'          => 'field_61156b777d403',
                            'label'        => 'Deadline Label',
                            'name'         => 'deadline_label',
                            'type'         => 'text',
                            'instructions' => '',
                            'required'     => 1,
                            'placeholder'  => 'Fall, Spring, etc.',
                            'maxlength'    => '',
                        ],
                        [
                            'key'          => 'field_61156bbe7d404',
                            'label'        => 'Deadline Info',
                            'name'         => 'deadline_info',
                            'type'         => 'text',
                            'instructions' => '',
                            'placeholder'  => 'e.g. June 24th',
                            'maxlength'    => '',
                        ],
                    ],
                ],
                [
                    'key'           => 'field_6171cbf69ba0a',
                    'label'         => 'Enable Block Editor for Personnel',
                    'name'          => 'nvis_enable_block_editor_personnel',
                    'type'          => 'true_false',
                    'instructions'  => 'Use the block editor to edit personnel profiles.',
                    'required'      => 0,
                    'default_value' => 1,
                    'ui'            => 1,
                ],
                [
                    'key'           => 'field_617308be36302',
                    'label'         => 'Main Content Wrapper Tag',
                    'name'          => 'nvis_main_content_wrapper_tag',
                    'type'          => 'select',
                    'instructions'  => 'Switch to "main" to alleviate accessibility issues with some themes.',
                    'default_value' => 'div',
                    'return_format' => 'value',
                    'choices'       => [
                        'div'  => 'div',
                        'main' => 'main',
                    ],
                ],
            ]
        ]
    ];

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

        self::setup_subpage_manager();
        $this->init_field_group();

        add_action('init', [self::class, 'plugin_init']);

        self::$_init = true;
    }

    /**
     * Performs some plugin setup.
     *
     * Called on action: init
     *
     * @return void
     */
    public static function plugin_init(): void {
        self::register_content_model();
        self::register_custom_blocks();
        self::setup_template_manager();
    }

    /**
     * Handles some dynamic configuration of the ACF field group.
     *
     * @return void
     */
    public function init_field_group(): void {
        $subpages = ProgramSubpageManager::get_subpages(false);
        $def_vals = [];

        $enable_subpages = [
            'key'           => 'field_612f7a95b683c',
            'label'         => 'Enable Program Subpages',
            'name'          => 'nvis_enable_program_subpages',
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

        array_unshift(self::$field_groups[0]['fields'], $enable_subpages);

        return;
    }

    /**
     * Registers all the custom post types and custom taxonomies.
     *
     * @return void
     */
    public static function register_content_model(): void {
        // Register post types.
        (new Program())->register();
        (new Course())->register();
        (new FAQ())->register();
        (new Person())->register();
        // Register taxonomies.
        (new ProgramType())->register();
        (new College())->register();
        (new DeliveryFormat())->register();
        (new Subject())->register();
        (new Semester())->register();
        (new PersonCategory())->register();
        (new Department())->register();
        (new FAQCategory())->register();

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

    /**
     * Creates and configures the ProgramSubpageManager.
     *
     * @return void
     */
    public static function setup_subpage_manager(): void {
        // TODO: Allow the order to be customized.
        $mngr = new ProgramSubpageManager([
            (object) [
                'slug'  => 'index',
                'title' => 'Overview'
            ],
            new CurriculumProgramSubpage(),
            new CareersProgramSubpage(),
            new FacultyStaffProgramSubpage(),
            new CostProgramSubpage(),
            new ApplyProgramSubpage(),
            new FAQProgramSubpage(),
            new NewsProgramSubpage()
        ]);
        $mngr->init();

        return;
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
