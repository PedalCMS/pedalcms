<?php

namespace InvisibleUs\Programs;

/**
 * Program custom post type.
 *
 * @package NVISPrograms
 * @subpackage ContentModel
 * @since 0.1.0
 */
class Program extends CustomPostType {
    /**
     * The post type to register.
     */
    public const POST_TYPE = 'nvis_program';

    /**
     * The proper name.
     *
     * @var string
     */
    public string $name = 'Program';

    /**
     * The plural version of the proper name.
     *
     * @var string
     */
    public string $plural_name = 'Programs';

    private static $subpage_manager = null;

    /**
     * The args to pass to register_post_type.
     *
     * Gets updated throughout the setup process.
     *
     * @var array
     */
    public array $args = [
        'has_archive'         => 'programs',
        'rewrite'             => ['slug' => 'program', 'with_front' => true],
        'capability_type'     => self::POST_TYPE,
        'menu_icon'           => 'dashicons-welcome-learn-more',
        'menu_position'       => 5,
        'description'         => '',
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'supports'            => ['title', 'thumbnail'],
    ];

    /**
     * A list of field group arrays to pass to acf_add_local_field_group.
     *
     * @var array
     */
    public static $field_groups = [
        [
            'key'         => 'group_61118a19b2e4c',
            'title'       => 'Program Info',
            'location'    => [
                [
                    [
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'nvis_program',
                    ],
                ],
            ],
            'menu_order'            => 0,
            'position'              => 'acf_after_title',
            'style'                 => 'seamless',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen'        => '',
            'active'                => true,
            'fields'                => [
                [
                    'key'       => 'field_6112749bd4b71',
                    'label'     => 'Main',
                    'type'      => 'tab',
                    'placement' => 'top',
                    'endpoint'  => 0,
                ],
                [
                    'key'          => 'field_6112773d640f4',
                    'label'        => 'Program GUID',
                    'name'         => 'program_guid',
                    'type'         => 'text',
                    'instructions' => 'The globally unique identifier for the program. Typically, used campus-wide across systems.',
                ],
                [
                    'key'           => 'field_611279af182d2',
                    'label'         => 'College',
                    'name'          => 'college',
                    'type'          => 'taxonomy',
                    'instructions'  => '',
                    'required'      => 1,
                    'taxonomy'      => College::TAXONOMY,
                    'field_type'    => 'select',
                    'allow_null'    => 0,
                    'add_term'      => 0,
                    'save_terms'    => 1,
                    'load_terms'    => 1,
                    'return_format' => 'object',
                    'multiple'      => 0,
                ],
                [
                    'key'           => 'field_61127c46a8faf',
                    'label'         => 'Program Type',
                    'name'          => 'program_type',
                    'type'          => 'taxonomy',
                    'instructions'  => '',
                    'required'      => 1,
                    'taxonomy'      => ProgramType::TAXONOMY,
                    'field_type'    => 'radio',
                    'allow_null'    => 0,
                    'add_term'      => 0,
                    'save_terms'    => 1,
                    'load_terms'    => 1,
                    'return_format' => 'object',
                    'multiple'      => 0,
                ],
                [
                    'key'           => 'field_61127a1f182d4',
                    'label'         => 'Instruction Mode',
                    'name'          => 'instruction_mode',
                    'type'          => 'taxonomy',
                    'instructions'  => '',
                    'taxonomy'      => InstructionMode::TAXONOMY,
                    'field_type'    => 'radio',
                    'allow_null'    => 0,
                    'add_term'      => 0,
                    'save_terms'    => 1,
                    'load_terms'    => 1,
                    'return_format' => 'object',
                    'multiple'      => 0,
                ],
                [
                    'key'           => 'field_61128ea8b1920',
                    'label'         => 'Prerequisites',
                    'name'          => 'prerequisites',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'message'       => '',
                    'default_value' => true,
                    'ui'            => 1,
                ],
                [
                    'key'           => 'field_6112738ed4b70',
                    'label'         => 'Overview Content',
                    'name'          => 'overview_content',
                    'type'          => 'wysiwyg',
                    'instructions'  => '',
                    'default_value' => '',
                    'tabs'          => 'all',
                    'toolbar'       => 'full',
                    'media_upload'  => 1,
                    'delay'         => 0,
                ],
                [
                    'key'          => 'field_61127d078fbcb',
                    'label'        => 'Request Info URL',
                    'name'         => 'url_request_info',
                    'type'         => 'url',
                    'instructions' => 'Overrides the global pattern for Request Info URLs.',
                    'placeholder'  => '',
                ],
                [
                    'key'          => 'field_61127d728fbcc',
                    'label'        => 'Apply Now URL',
                    'name'         => 'url_apply_now',
                    'type'         => 'url',
                    'instructions' => 'Overrides the global pattern for Apply Now URLs.',
                    'placeholder'  => '',
                ],
                [
                    'key'          => 'field_61127d948fbcd',
                    'label'        => 'Contact Us URL',
                    'name'         => 'url_contact_us',
                    'type'         => 'url',
                    'instructions' => 'Overrides the global pattern for Contact Us URLs.',
                    'placeholder'  => '',
                ],
                [
                    'key'           => 'field_6138d5c7722ca',
                    'label'         => 'Show Application Deadlines?',
                    'name'          => 'show_application_deadlines',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'message'       => '',
                    'default_value' => true,
                    'ui'            => 1,
                ],
                [
                    'key'          => 'field_613a6d0cce1eb',
                    'label'        => 'Application Deadlines',
                    'name'         => 'application_deadlines',
                    'type'         => 'repeater',
                    'instructions' => 'Leave blank to inherit.',
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
                    'conditional_logic' => [
                        [
                            [
                                'field'    => 'field_6138d5c7722ca',
                                'operator' => '==',
                                'value'    => '1'
                            ],
                        ],
                    ]
                ],
                [
                    'key'          => 'field_611276e3640f3',
                    'label'        => 'Program Contacts',
                    'name'         => 'related_contacts',
                    'type'         => 'relationship',
                    'instructions' => '',
                    'post_type'    => [
                        0 => 'nvis_person',
                    ],
                    'taxonomy' => '',
                    'filters'  => [
                        0 => 'search',
                    ],
                    'elements' => [
                        0 => 'featured_image',
                    ],
                    'min'           => '',
                    'max'           => '',
                    'return_format' => 'object',
                ]
            ]
        ]
    ];

    public static $subpages = [
        'index' => [
            'title' => 'Overview',
            'order' => -1,
            'builtin' => true
        ],
        'curriculum' => [
            'title' => 'Curriculum',
            'order' => 10,
            'builtin' => true,
            'fields' => [
                [
                    'key'           => 'field_6112835dfeb44',
                    'label'         => 'Show Curriculum Section?',
                    'name'          => 'show_curriculum_section',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'message'       => '',
                    'default_value' => true,
                    'ui'            => 1,
                    'ui_on_text'    => '',
                    'ui_off_text'   => '',
                ],
                [
                    'key'           => 'field_615f0ea5ecd84',
                    'label'         => 'Curriculum Lead Content',
                    'name'          => 'curriculum_lead',
                    'type'          => 'wysiwyg',
                    'instructions'  => 'This content goes before the list of curriculum sections.',
                    'default_value' => '',
                    'tabs'          => 'all',
                    'toolbar'       => 'full',
                    'media_upload'  => 1,
                    'delay'         => 1,
                ],
                [
                    'key'          => 'field_615f0c5a22deb',
                    'label'        => 'Curriculum Sections',
                    'name'         => 'curriculum_sections',
                    'type'         => 'repeater',
                    'instructions' => '',
                    'collapsed'    => 'field_615f0c8022dec',
                    'layout'       => 'block',
                    'button_label' => 'Add Section',
                    'sub_fields'   => [
                        [
                            'key'          => 'field_615f0c8022dec',
                            'label'        => 'Section Title',
                            'name'         => 'section_title',
                            'type'         => 'text',
                            'instructions' => '',
                            'placeholder'  => 'Math Requirements, etc.',
                            'prepend'      => '',
                            'append'       => '',
                            'maxlength'    => '',
                        ],
                        [
                            'key'               => 'field_615f0cd622ded',
                            'label'             => 'Section Content',
                            'name'              => 'section_content',
                            'type'              => 'wysiwyg',
                            'instructions'      => 'Some preamble or instructions about the courses below. For example, "Choose two of the following."',
                            'required'          => 0,
                            'conditional_logic' => 0,
                            'wrapper'           => [
                                'width' => '',
                                'class' => '',
                                'id'    => '',
                            ],
                            'tabs'          => 'all',
                            'toolbar'       => 'basic',
                            'media_upload'  => 0,
                            'delay'         => 1,
                        ],
                        [
                            'key'          => 'field_615f0d7322dee',
                            'label'        => 'Section Courses',
                            'name'         => 'section_courses',
                            'type'         => 'relationship',
                            'instructions' => '',
                            'post_type'    => [
                                0 => 'nvis_course',
                            ],
                            'filters'  => [
                                0 => 'search',
                                1 => 'taxonomy',
                            ],
                            'return_format' => 'object',
                        ],
                    ],
                ],
            ]
        ],
        'careers' => [
            'title' => 'Careers',
            'aria_label' => 'Careers related to the current program',
            'order' => 20,
            'builtin' => true,
            'fields' => [
                [
                    'key'           => 'field_61118a6ecb6c0',
                    'label'         => 'Show Careers Section?',
                    'name'          => 'show_careers_section',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'message'       => '',
                    'default_value' => true,
                    'ui'            => 1,
                    'ui_on_text'    => '',
                    'ui_off_text'   => '',
                ],
                [
                    'key'           => 'field_611275a9d4b74',
                    'label'         => 'Careers Lead Content',
                    'name'          => 'careers_lead',
                    'type'          => 'wysiwyg',
                    'instructions'  => '',
                    'default_value' => '',
                    'tabs'          => 'all',
                    'toolbar'       => 'full',
                    'media_upload'  => 1,
                    'delay'         => 1,
                ],
                [
                    'key'          => 'field_6112754dd4b73',
                    'label'        => 'Related Careers',
                    'name'         => 'related_careers',
                    'type'         => 'relationship',
                    'instructions' => '',
                    'post_type'    => [
                        0 => 'nvis_career',
                    ],
                    'taxonomy' => '',
                    'filters'  => [
                        0 => 'search',
                        1 => 'taxonomy',
                    ],
                    'elements'      => '',
                    'min'           => '',
                    'max'           => '',
                    'return_format' => 'object',
                ]
            ]
        ],
        'faculty-staff' => [
            'title' => 'Faculty & Staff',
            'aria_label' => 'Faculty & staff related to the current program',
            'order' => 30,
            'builtin' => true,
            'fields' => [
                [
                    'key'           => 'field_613b63fa499ce',
                    'label'         => 'Show Faculty & Staff Section?',
                    'name'          => 'show_faculty_staff_section',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'message'       => '',
                    'default_value' => true,
                    'ui'            => 1,
                    'ui_on_text'    => '',
                    'ui_off_text'   => '',
                ],
                [
                    'key'           => 'field_613b6446aae76',
                    'label'         => 'Faculty & Staff Lead Content',
                    'name'          => 'faculty_staff_lead',
                    'type'          => 'wysiwyg',
                    'instructions'  => '',
                    'default_value' => '',
                    'tabs'          => 'all',
                    'toolbar'       => 'full',
                    'media_upload'  => 1,
                    'delay'         => 1,
                ],
                [
                    'key'           => 'field_613b6ecd4687a',
                    'label'         => 'Group by category?',
                    'name'          => 'faculty_staff_by_category',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'message'       => '',
                    'default_value' => true,
                    'ui'            => 1,
                    'ui_on_text'    => '',
                    'ui_off_text'   => '',
                ],
                [
                    'key'          => 'field_613b6de416aa1',
                    'label'        => 'Related Faculty & Staff',
                    'name'         => 'related_faculty_staff',
                    'type'         => 'relationship',
                    'instructions' => '',
                    'post_type'    => [
                        0 => 'nvis_person',
                    ],
                    'taxonomy' => '',
                    'filters'  => [
                        0 => 'search',
                    ],
                    'elements' => [
                        0 => 'featured_image',
                    ],
                    'min'           => '',
                    'max'           => '',
                    'return_format' => 'object',
                ]
            ]
        ],
        'cost' => [
            'title' => 'Cost',
            'order' => 40,
            'builtin' => true,
            'fields' => [
                [
                    'key'           => 'field_6124eebb8a99e',
                    'label'         => 'Show Cost Section?',
                    'name'          => 'show_cost_section',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'message'       => '',
                    'default_value' => true,
                    'ui'            => 1,
                    'ui_on_text'    => '',
                    'ui_off_text'   => '',
                ],[
                    'key'           => 'field_617848545496b',
                    'label'         => 'Estimated Cost Label',
                    'name'          => 'estimated_cost_label',
                    'type'          => 'text',
                    'instructions'  => '',
                    'placeholder'   => 'Estimated Cost',
                ],
                [
                    'key'               => 'field_6178492a5496c',
                    'label'             => 'Estimated Cost',
                    'name'              => 'estimated_cost',
                    'type'              => 'text',
                    'instructions'      => 'Leave blank to omit this field.'
                ],
                [
                    'key'           => 'field_61327ef17bf0d',
                    'label'         => 'Cost Content',
                    'name'          => 'cost_content',
                    'type'          => 'wysiwyg',
                    'instructions'  => '',
                    'default_value' => '',
                    'tabs'          => 'all',
                    'toolbar'       => 'full',
                    'media_upload'  => 1,
                    'delay'         => 1,
                ],
            ]
        ],
        'apply' => [
            'title' => 'How to Apply',
            'order' => 50,
            'builtin' => true,
            'fields' => [
                [
                    'key'           => 'field_611d69fb7f47f',
                    'label'         => 'Show Apply Section?',
                    'name'          => 'show_apply_section',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'message'       => '',
                    'default_value' => true,
                    'ui'            => 1,
                    'ui_on_text'    => '',
                    'ui_off_text'   => '',
                ],
                [
                    'key'           => 'field_611d6bfe199d9',
                    'label'         => 'Apply Content',
                    'name'          => 'apply_content',
                    'type'          => 'wysiwyg',
                    'instructions'  => '',
                    'default_value' => '',
                    'tabs'          => 'all',
                    'toolbar'       => 'full',
                    'media_upload'  => 1,
                    'delay'         => 1,
                ],
            ]
        ],
        'faqs' => [
            'title' => 'FAQs',
            'aria_label' => 'FAQs related to the current program',
            'order' => 60,
            'builtin' => true,
            'fields' => [
                [
                    'key'           => 'field_61118aa8cb6c2',
                    'label'         => 'Show FAQs Section?',
                    'name'          => 'show_faqs_section',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'message'       => '',
                    'default_value' => true,
                    'ui'            => 1,
                    'ui_on_text'    => '',
                    'ui_off_text'   => '',
                ],
                [
                    'key'           => 'field_6113d61abfe26',
                    'label'         => 'Group FAQs by category?',
                    'name'          => 'faqs_by_category',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'message'       => '',
                    'default_value' => true,
                    'ui'            => 1,
                    'ui_on_text'    => '',
                    'ui_off_text'   => '',
                ],
                [
                    'key'           => 'field_6112760bd4b75',
                    'label'         => 'FAQs Lead Content',
                    'name'          => 'faqs_lead',
                    'type'          => 'wysiwyg',
                    'instructions'  => '',
                    'default_value' => '',
                    'tabs'          => 'all',
                    'toolbar'       => 'full',
                    'media_upload'  => 1,
                    'delay'         => 1,
                ],
                [
                    'key'          => 'field_61701a9d36062',
                    'label'        => 'Related FAQs',
                    'name'         => 'related_faqs_list',
                    'type'         => 'repeater',
                    'instructions' => '',
                    'collapsed'    => 'field_61701ac036063',
                    'layout'       => 'row',
                    'button_label' => 'Add Question',
                    'sub_fields'   => [
                        [
                            'key'           => 'field_61701ac036063',
                            'label'         => 'FAQ Type',
                            'name'          => 'faq_type',
                            'type'          => 'radio',
                            'instructions'  => 'Select the type of FAQ you would like to add.',
                            'required'      => 1,
                            'layout'        => 'vertical',
                            'return_format' => 'value',
                            'choices'       => [
                                'global' => 'Global',
                                'local'  => 'Program Specific',
                            ],
                        ],
                        [
                            'key'               => 'field_61701bf236064',
                            'label'             => 'Global FAQ',
                            'name'              => 'faq_post',
                            'type'              => 'post_object',
                            'instructions'      => 'Select the global question.',
                            'required'          => 1,
                            'taxonomy'          => '',
                            'allow_null'        => 0,
                            'multiple'          => 0,
                            'return_format'     => 'object',
                            'ui'                => 1,
                            'post_type'         => [
                                0 => 'nvis_faq',
                            ],
                            'conditional_logic' => [
                                [
                                    [
                                        'field'    => 'field_61701ac036063',
                                        'operator' => '==',
                                        'value'    => 'global',
                                    ],
                                ],
                            ],
                        ],
                        [
                            'key'               => 'field_61701c8536065',
                            'label'             => 'Question',
                            'name'              => 'question',
                            'type'              => 'text',
                            'instructions'      => 'Enter the question text.',
                            'placeholder'       => 'What is the question?',
                            'required'          => 1,
                            'conditional_logic' => [
                                [
                                    [
                                        'field'    => 'field_61701ac036063',
                                        'operator' => '==',
                                        'value'    => 'local',
                                    ],
                                ],
                            ],
                        ],
                        [
                            'key'               => 'field_61701cc336066',
                            'label'             => 'Answer',
                            'name'              => 'answer',
                            'type'              => 'wysiwyg',
                            'instructions'      => '',
                            'required'          => 1,
                            'default_value'     => '',
                            'tabs'              => 'all',
                            'toolbar'           => 'basic',
                            'media_upload'      => 0,
                            'delay'             => 1,
                            'conditional_logic' => [
                                [
                                    [
                                        'field'    => 'field_61701ac036063',
                                        'operator' => '==',
                                        'value'    => 'local',
                                    ],
                                ],
                            ],
                        ],
                        [
                            'key'               => 'field_61701cf336067',
                            'label'             => 'Category',
                            'name'              => 'faq_category',
                            'type'              => 'taxonomy',
                            'instructions'      => '',
                            'required'          => 1,
                            'taxonomy'          => 'nvis_faq_cat',
                            'field_type'        => 'select',
                            'allow_null'        => 0,
                            'add_term'          => 0,
                            'save_terms'        => 0,
                            'load_terms'        => 0,
                            'return_format'     => 'object',
                            'multiple'          => 0,
                            'conditional_logic' => [
                                [
                                    [
                                        'field'    => 'field_6113d61abfe26',
                                        'operator' => '==',
                                        'value'    => '1',
                                    ],
                                    [
                                        'field'    => 'field_61701ac036063',
                                        'operator' => '==',
                                        'value'    => 'local',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ],
        'news' => [
            'title' => 'News',
            'aria_label' => 'News related to the current program',
            'order' => 70,
            'builtin' => true,
            'fields' => [
                [
                    'key'           => 'field_611fdfdc20be6',
                    'label'         => 'Show News Section?',
                    'name'          => 'show_news_section',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'message'       => '',
                    'default_value' => true,
                    'ui'            => 1,
                    'ui_on_text'    => '',
                    'ui_off_text'   => '',
                ],
                [
                    'key'           => 'field_611fe01c20be7',
                    'label'         => 'News Tag',
                    'name'          => 'news_tag',
                    'type'          => 'taxonomy',
                    'instructions'  => 'The tag that should associate posts with this program.',
                    'taxonomy'      => 'post_tag',
                    'field_type'    => 'select',
                    'allow_null'    => 1,
                    'add_term'      => 1,
                    'save_terms'    => 0,
                    'load_terms'    => 0,
                    'return_format' => 'id',
                    'multiple'      => 0,
                    'wrapper'       => [
                        'width' => '33',
                        'class' => '',
                        'id'    => '',
                    ],
                ],
                [
                    'key'           => 'field_6124f029ff016',
                    'label'         => 'Number of Posts',
                    'name'          => 'news_num_posts',
                    'type'          => 'number',
                    'instructions'  => 'Number of posts to show on this subpage. Set to -1 to show all.',
                    'default_value' => 10,
                    'placeholder'   => '10',
                    'min'           => -1,
                    'step'          => 1,
                    'wrapper'       => [
                        'width' => '33',
                        'class' => '',
                        'id'    => '',
                    ],
                ],
                [
                    'key'           => 'field_6124f184ff017',
                    'label'         => 'Show link to all posts?',
                    'name'          => 'news_show_all_link',
                    'type'          => 'true_false',
                    'instructions'  => 'Link to the tag archive view at the bottom of the list?',
                    'default_value' => 1,
                    'ui'            => 1,
                    'wrapper'       => [
                        'width' => '33',
                        'class' => '',
                        'id'    => '',
                    ],
                ],
                [
                    'key'          => 'field_61263568d2f46',
                    'label'        => 'Featured Posts',
                    'name'         => 'news_featured_posts',
                    'type'         => 'post_object',
                    'instructions' => 'Select posts to keep at the top of the news subpage.',
                    'post_type'    => [
                        0 => 'post',
                    ],
                    'allow_null'    => 1,
                    'multiple'      => 1,
                    'return_format' => 'object',
                    'ui'            => 1,
                ],
                [
                    'key'           => 'field_611fdfd220be5',
                    'label'         => 'News Lead Content',
                    'name'          => 'news_lead',
                    'type'          => 'wysiwyg',
                    'instructions'  => 'Content to appear at the top of the page, before the posts.',
                    'default_value' => '',
                    'tabs'          => 'all',
                    'toolbar'       => 'full',
                    'media_upload'  => 1,
                    'delay'         => 1,
                ]
            ]
        ]
    ];

    public function setup_hooks(): void {
        add_action('pre_get_posts', [static::class, 'update_sort_order']);
    }

    /**
     * Changes the sort order for Programs.
     *
     * Called on filter: pre_get_posts
     *
     * @param WP_Query $query The current WP_Query
     * @return void
     */
    public static function update_sort_order(\WP_Query $query): void {
        // TODO: Limit this to main query.
        if (is_post_type_archive(self::POST_TYPE)) {
            $query->set('order', 'ASC');
            $query->set('orderby', 'title');
        }

        return;
    }

    /**
     * Get the news posts for a given program by related tag.
     *
     * Meta field news_tag must be set first.
     *
     * @param mixed $program Program to check for news posts. Either ID or WP_Post.
     * @param array $not_in List of ids to exclude from the results.
     * @return array List of WP_Posts that match the Program's tag.
     */
    public static function get_related_posts($program = null, array $not_in = []): array {
        $program = get_post($program);

        $tag = get_field('news_tag', $program);
        $num_posts = get_field('news_num_posts', $program);

        if (!$tag) {
            return [];
        }

        $args = [
            'tag_id'              => $tag,
            'ignore_sticky_posts' => true,
            'posts_per_page'      => $num_posts
        ];

        if (!empty($not_in)) {
            $args['post__not_in'] = $not_in;
        }

        return get_posts($args);
    }

    /**
     * Gets a list of application deadlines based on override hierarchy.
     *
     * Hierarchy is Program, College, Program Type, Global.
     *
     * @param mixed $program Program to check for news posts. Either ID or WP_Post.
     * @return array An ACF repeater field with deadline_label and deadline_info subfields.
     */
    public static function get_application_deadlines($program = null): array {
        $program = get_post($program);

        // First, check if the program has specific deadlines.
        $deadlines = get_field('application_deadlines', $program);

        if (!empty($deadlines)) {
            return $deadlines;
        }

        // Then, check if either the college or the program type has overriden.
        // TODO: Make these references.
        $terms = ['college','program_type'];

        foreach ($terms as $name) {
            $term = get_field($name, $program);

            if (!empty($term)) {
                $deadlines = get_field('application_deadlines', $term);

                if (!empty($deadlines)) {
                    return $deadlines;
                }
            }
        }

        // If all else fails, just return the global setting.
        return Plugin::get_option('application_deadlines');
    }

    public static function setup_subpage_manager() {
        self::$subpage_manager = new SubpageManager(Program::POST_TYPE);

        foreach(Program::$subpages as $slug => $args) {
            $subpage = new Subpage($slug, $args);
            self::$subpage_manager->add_subpage($subpage);
        }
    }

    public static function subpage_manager() {
        return self::$subpage_manager;
    }
}
