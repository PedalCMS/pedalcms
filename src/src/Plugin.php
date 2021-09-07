<?php

namespace InvisibleUs\Programs;

class Plugin {
    public static $name = '';
    public static $path = '';
    public static $url = '';
    public static $template_path = '/templates';

    public static $options_page = [
        'page_title'  => 'Program Pages Settings',
        'menu_title'  => 'Program Pages',
        'menu_slug'   => 'nvis-program-pages-settings',
        'capability'  => 'manage_options',
        'parent_slug' => 'options-general.php',
        'position'    => 7,
        'redirect'    => false,
    ];

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
                    'key'               => 'field_612e8eb51b6a6',
                    'label'             => 'Course More Info URL',
                    'name'              => 'nvis_course_url_more_info',
                    'type'              => 'url',
                    'instructions'      => 'Enter a URL pattern to create unique "More info" URLs for each course. You can use the following tags: {$course_cat_key} {$course_reg_key}',
                    'placeholder'       => '',
                ],
                [
                    'key'               => 'field_612e8f1e1b6a7',
                    'label'             => 'Course Registration Search URL',
                    'name'              => 'nvis_course_url_reg_search',
                    'type'              => 'url',
                    'instructions'      => 'Enter a URL pattern to create unique "Search Sections" URLs for each course. You can use the following tags: {$course_cat_key} {$course_reg_key}',
                    'placeholder'       => '',
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
            ]
        ]
    ];

    public function __construct() {
        self::$name = basename(dirname(__DIR__, 2));
        self::$path = dirname(__DIR__, 2);
        self::$url = plugins_url(self::$name);
        self::$template_path = self::$path . self::$template_path;

        $this->init_field_group();
    }

    public static function init_field_group(): void {
        $subpages = ProgramSubpageManager::get_subpages(false);
        $def_vals = [];

        $enable_subpages = [
            'key'           => 'field_612f7a95b683c',
            'label'         => 'Enable Program Subpages',
            'name'          => 'enable_program_subpages',
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
}
