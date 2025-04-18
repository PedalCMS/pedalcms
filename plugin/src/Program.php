<?php

namespace PedalCMS\Core;

/**
 * Program custom post type.
 *
 * @package PedalCMS
 * @subpackage ContentModel
 * @since 0.1.0
 */
class Program extends CustomPostType {
    /**
     * The post type to register.
     *
     * @since 0.1.0
     *
     * @var string
     */
    public const POST_TYPE = 'pdl_program';

    private static $subpage_manager = null;

    /**
     * The args to pass to register_post_type.
     *
     * Gets updated throughout the setup process.
     *
     * @since 0.1.0
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
        'publicly_queryable'  => true,
        'show_in_rest'        => true,
        'rest_base'           => 'programs',
        'rest_controller_class'           => 'WP_REST_Posts_Controller',
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => 'program',
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'supports'            => ['title', 'thumbnail'],
    ];

    /**
     * The list of subpages to register.
     *
     * Includes subpage ACF field definitions.
     *
     * @since 0.1.0
     *
     * @var array
     */
    public static $subpages = [];

    protected function setup_labels(): void {
        $this->args['labels'] = [
            'name'                     => _x( 'Programs', 'post type general name', 'pedalcms' ),
            'singular_name'            => _x( 'Program', 'post type singular name', 'pedalcms' ),
            'add_new_item'             => __( 'Add New Program', 'pedalcms' ),
            'edit_item'                => __( 'Edit Program', 'pedalcms' ),
            'new_item'                 => __( 'New Program', 'pedalcms' ),
            'view_item'                => __( 'View Program', 'pedalcms' ),
            'view_items'               => __( 'View Programs', 'pedalcms' ),
            'search_items'             => __( 'Search Programs', 'pedalcms' ),
            'not_found'                => __( 'No programs found.', 'pedalcms' ),
            'not_found_in_trash'       => __( 'No programs found in Trash.', 'pedalcms' ),
            'parent_item_colon'        => __( 'Parent Program:', 'pedalcms' ),
            'all_items'                => __( 'All Programs', 'pedalcms' ),
            'archives'                 => __( 'Programs', 'pedalcms' ),
            'attributes'               => __( 'Program Attributes', 'pedalcms' ),
            'insert_into_item'         => __( 'Insert into program', 'pedalcms' ),
            'uploaded_to_this_item'    => __( 'Uploaded to this program', 'pedalcms' ),
            'filter_items_list'        => __( 'Filter programs list', 'pedalcms' ),
            'items_list_navigation'    => __( 'Programs list navigation', 'pedalcms' ),
            'items_list'               => __( 'Programs list', 'pedalcms' ),
            'item_published'           => __( 'Program published.', 'pedalcms' ),
            'item_published_privately' => __( 'Program published privately.', 'pedalcms' ),
            'item_reverted_to_draft'   => __( 'Program reverted to draft.', 'pedalcms' ),
            'item_scheduled'           => __( 'Program scheduled.', 'pedalcms' ),
            'item_updated'             => __( 'Program updated.', 'pedalcms' ),
            'item_link'                => _x( 'Program Link', 'navigation link block title', 'pedalcms' ),
            'item_link_description'    => _x( 'A link to a program.', 'navigation link block description', 'pedalcms' ),
        ];
    }

    protected function setup_field_group() {
        $field_group = [
            'key'         => 'group_61118a19b2e4c',
            'title'       => _x('Program Info', 'field group title','pedalcms'),
            'location'    => [
                [
                    [
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'pdl_program',
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
                    'label'     => __('Main','pedalcms'),
                    'type'      => 'tab',
                    'placement' => 'top',
                    'endpoint'  => 0,
                ],
                [
                    'key'          => 'field_6112773d640f4',
                    'label'        => __('Program GUID','pedalcms'),
                    'name'         => 'program_guid',
                    'type'         => 'text',
                    'instructions' => __('The globally unique identifier for the program. Typically, used campus-wide across systems.', 'pedalcms'),
                ],
                [
                    'key'           => 'field_611279af182d2',
                    'label'         => __('College','pedalcms'),
                    'name'          => 'college',
                    'type'          => 'taxonomy',
                    'instructions'  => '',
                    'required'      => 0,
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
                    'key'           => 'field_630fb69367bc5',
                    'label'         => __('Department','pedalcms'),
                    'name'          => 'department',
                    'type'          => 'select',
                    'instructions'  => '',
                    'placeholder'   => __('Select department', 'pedalcms'),
                    'default_value' => 0,
                    'required'      => 0,
                    'taxonomy'      => Department::TAXONOMY,
                    'field_type'    => 'select',
                    'allow_null'    => 0,
                    'add_term'      => 0,
                    'save_terms'    => 0,
                    'load_terms'    => 0,
                    'return_format' => 'id',
                    'multiple'      => 0,
                    'ui'            => 0,
                    'ajax'          => 0,
                    'disable'       => 1,
                    'choices'       => [
                        0 => __('(Select college first)', 'pedalcms')
                    ]
                ],
                [
                    'key'           => 'field_61127c46a8faf',
                    'label'         => __('Program Type','pedalcms'),
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
                    'label'         => __('Instruction Mode','pedalcms'),
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
                    'label'         => __('Prerequisites','pedalcms'),
                    'name'          => 'prerequisites',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'message'       => '',
                    'default_value' => true,
                    'ui'            => 1,
                ],
                [
                    'key'           => 'field_6112738ed4b70',
                    'label'         => __('Overview Content','pedalcms'),
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
                    'label'        => __('Request Info URL','pedalcms'),
                    'name'         => 'url_request_info',
                    'type'         => 'url',
                    'instructions' => __('Overrides the global pattern for Request Info URLs.','pedalcms'),
                    'placeholder'  => '',
                ],
                [
                    'key'          => 'field_61127d728fbcc',
                    'label'        => __('Apply Now URL','pedalcms'),
                    'name'         => 'url_apply_now',
                    'type'         => 'url',
                    'instructions' => __('Overrides the global pattern for Apply Now URLs.','pedalcms'),
                    'placeholder'  => '',
                ],
                [
                    'key'          => 'field_61127d948fbcd',
                    'label'        => __('Contact Us URL','pedalcms'),
                    'name'         => 'url_contact_us',
                    'type'         => 'url',
                    'instructions' => __('Overrides the global pattern for Contact Us URLs.','pedalcms'),
                    'placeholder'  => '',
                ],
                [
                    'key'           => 'field_6138d5c7722ca',
                    'label'         => __('Show Application Deadlines?','pedalcms'),
                    'name'          => 'show_application_deadlines',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'message'       => '',
                    'default_value' => true,
                    'ui'            => 1,
                ],
                [
                    'key'          => 'field_613a6d0cce1eb',
                    'label'        => __('Application Deadlines','pedalcms'),
                    'name'         => 'application_deadlines',
                    'type'         => 'repeater',
                    'instructions' => __('Leave blank to inherit.','pedalcms'),
                    'collapsed'    => 'field_61156b777d403',
                    'layout'       => 'block',
                    'button_label' => _x('Add Deadline', 'new deadline button label','pedalcms'),
                    'sub_fields'   => [
                        [
                            'key'          => 'field_61156b777d403',
                            'label'        => __('Deadline Label','pedalcms'),
                            'name'         => 'label',
                            'type'         => 'text',
                            'instructions' => '',
                            'required'     => 1,
                            'placeholder'  => _x('Fall, Spring, etc.', 'deadline label field placeholder', 'pedalcms'),
                            'maxlength'    => '',
                        ],
                        [
                            'key'          => 'field_61156bbe7d404',
                            'label'        => __('Deadline Info','pedalcms'),
                            'name'         => 'info',
                            'type'         => 'text',
                            'instructions' => '',
                            'placeholder'  => _x('e.g. June 24th', 'deadline info field placeholder', 'pedalcms'),
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
                    'label'        => __('Program Contacts','pedalcms'),
                    'name'         => 'related_contacts',
                    'type'         => 'relationship',
                    'instructions' => '',
                    'post_type'    => [
                        0 => 'pdl_person',
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
        ];

        if (Program::$subpage_manager) {
            $field_group['fields'] = array_merge(
                $field_group['fields'],
                Program::$subpage_manager->get_enabled_subpage_fields()
            );
        }

        $this->field_groups[] = $field_group;
    }

    protected static function setup_subpages() {
        self::$subpages = [
            'index' => [
                'title' => _x('Overview', 'Proper subpage title','pedalcms'),
                'order' => -1,
                'builtin' => true
            ],
            'curriculum' => [
                'title' => _x('Curriculum','Proper subpage title','pedalcms'),
                'order' => 10,
                'builtin' => true,
                'fields' => [
                    [
                        'key'           => 'field_6112835dfeb44',
                        'label'         => __('Show Curriculum Section?','pedalcms'),
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
                        'label'         => _x('Lead Content', 'Curriculum','pedalcms'),
                        'name'          => 'curriculum_lead',
                        'type'          => 'wysiwyg',
                        'instructions'  => __('This content goes before the list of curriculum sections.','pedalcms'),
                        'default_value' => '',
                        'tabs'          => 'all',
                        'toolbar'       => 'full',
                        'media_upload'  => 1,
                        'delay'         => 1,
                    ],
                    [
                        'key'          => 'field_615f0c5a22deb',
                        'label'        => __('Curriculum Sections','pedalcms'),
                        'name'         => 'curriculum_sections',
                        'type'         => 'repeater',
                        'instructions' => '',
                        'collapsed'    => 'field_615f0c8022dec',
                        'layout'       => 'block',
                        'button_label' => _x('Add Section','New section button label','pedalcms'),
                        'sub_fields'   => [
                            [
                                'key'          => 'field_615f0c8022dec',
                                'label'        => __('Section Title','pedalcms'),
                                'name'         => 'section_title',
                                'type'         => 'text',
                                'instructions' => '',
                                'placeholder'  => __('Math Requirements, etc.','pedalcms'),
                                'prepend'      => '',
                                'append'       => '',
                                'maxlength'    => '',
                            ],
                            [
                                'key'               => 'field_615f0cd622ded',
                                'label'             => __('Section Content','pedalcms'),
                                'name'              => 'section_content',
                                'type'              => 'wysiwyg',
                                'instructions'      => __('Some preamble or instructions about the courses below. For example, "Choose two of the following."','pedalcms'),
                                'required'          => 0,
                                'conditional_logic' => 0,
                                'wrapper'           => [
                                    'width' => '',
                                    'class' => '',
                                    'id'    => '',
                                ],
                                'tabs'          => 'all',
                                'toolbar'       => 'full',
                                'media_upload'  => 0,
                                'delay'         => 1,
                            ],
                            [
                                'key'          => 'field_615f0d7322dee',
                                'label'        => __('Section Courses','pedalcms'),
                                'name'         => 'section_courses',
                                'type'         => 'relationship',
                                'instructions' => '',
                                'post_type'    => [
                                    0 => 'pdl_course',
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
                'title' => _x('Careers', 'Proper subpage title','pedalcms'),
                'aria_label' => __('Careers related to the current program','pedalcms'),
                'order' => 20,
                'builtin' => true,
                'fields' => [
                    [
                        'key'           => 'field_61118a6ecb6c0',
                        'label'         => __('Show Careers Section?','pedalcms'),
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
                        'label'         => _x('Lead Content', 'Careers','pedalcms'),
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
                        'label'        => __('Related Careers','pedalcms'),
                        'name'         => 'related_program_careers',
                        'type'         => 'relationship',
                        'instructions' => '',
                        'post_type'    => [
                            0 => 'pdl_career',
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
                'title' => _x('Faculty & Staff','Proper subpage title','pedalcms'),
                'aria_label' => __('Faculty & staff related to the current program','pedalcms'),
                'order' => 30,
                'builtin' => true,
                'fields' => [
                    [
                        'key'           => 'field_613b63fa499ce',
                        'label'         => __('Show Faculty & Staff Section?','pedalcms'),
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
                        'label'         => _x('Lead Content', 'Faculty & Staff','pedalcms'),
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
                        'label'         => __('Group by category?','pedalcms'),
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
                        'label'        => __('Related Faculty & Staff','pedalcms'),
                        'name'         => 'related_faculty_staff',
                        'type'         => 'relationship',
                        'instructions' => '',
                        'post_type'    => [
                            0 => 'pdl_person',
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
                'title' => _x('Cost','Proper subpage title','pedalcms'),
                'order' => 40,
                'builtin' => true,
                'fields' => [
                    [
                        'key'           => 'field_6124eebb8a99e',
                        'label'         => __('Show Cost Section?','pedalcms'),
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
                        'label'         => __('Estimated Cost Label','pedalcms'),
                        'name'          => 'estimated_cost_label',
                        'type'          => 'text',
                        'instructions'  => '',
                        'placeholder'   => _x('Estimated Cost', 'field placeholder','pedalcms'),
                    ],
                    [
                        'key'               => 'field_6178492a5496c',
                        'label'             => _x('Estimated Cost', 'field label','pedalcms'),
                        'name'              => 'estimated_cost',
                        'type'              => 'text',
                        'instructions'      => __('Leave blank to omit this field.','pedalcms'),
                    ],
                    [
                        'key'           => 'field_61327ef17bf0d',
                        'label'         => __('Cost Content','pedalcms'),
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
                'title' => _x('How to Apply','Proper subpage title','pedalcms'),
                'order' => 50,
                'builtin' => true,
                'fields' => [
                    [
                        'key'           => 'field_611d69fb7f47f',
                        'label'         => __('Show Apply Section?','pedalcms'),
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
                        'label'         => __('Apply Content','pedalcms'),
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
                'title' => _x('FAQs','Proper subpage title','pedalcms'),
                'aria_label' => __('FAQs related to the current program','pedalcms'),
                'order' => 60,
                'builtin' => true,
                'fields' => [
                    [
                        'key'           => 'field_61118aa8cb6c2',
                        'label'         => __('Show FAQs Section?','pedalcms'),
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
                        'label'         => __('Group FAQs by category?','pedalcms'),
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
                        'label'         => _x('Lead Content', 'FAQs','pedalcms'),
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
                        'label'        => __('Related FAQs','pedalcms'),
                        'name'         => 'related_faqs_list',
                        'type'         => 'repeater',
                        'instructions' => '',
                        'collapsed'    => 'field_61701ac036063',
                        'layout'       => 'row',
                        'button_label' => _x('Add Question', 'new question button label','pedalcms'),
                        'sub_fields'   => [
                            [
                                'key'           => 'field_61701ac036063',
                                'label'         => __('FAQ Type','pedalcms'),
                                'name'          => 'faq_type',
                                'type'          => 'radio',
                                'instructions'  => __('Select the type of FAQ you would like to add.','pedalcms'),
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
                                'label'             => _x('Global FAQ', 'faqs relevant to all programs','pedalcms'),
                                'name'              => 'faq_post',
                                'type'              => 'post_object',
                                'instructions'      => __('Select the global question.','pedalcms'),
                                'required'          => 1,
                                'taxonomy'          => '',
                                'allow_null'        => 0,
                                'multiple'          => 0,
                                'return_format'     => 'object',
                                'ui'                => 1,
                                'post_type'         => [
                                    0 => 'pdl_faq',
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
                                'label'             => __('Question','pedalcms'),
                                'name'              => 'question',
                                'type'              => 'text',
                                'instructions'      => __('Enter the question text.','pedalcms'),
                                'placeholder'       => _x('What is the question?', 'question field placeholder','pedalcms'),
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
                                'label'             => __('Answer','pedalcms'),
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
                                'label'             => __('Category','pedalcms'),
                                'name'              => 'faq_category',
                                'type'              => 'taxonomy',
                                'instructions'      => '',
                                'required'          => 1,
                                'taxonomy'          => 'pdl_faq_cat',
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
                'title' => _x('News','Proper subpage title','pedalcms'),
                'aria_label' => __('News related to the current program','pedalcms'),
                'order' => 70,
                'builtin' => true,
                'fields' => [
                    [
                        'key'           => 'field_611fdfdc20be6',
                        'label'         => __('Show News Section?','pedalcms'),
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
                        'label'         => _x('News Tag', 'tag of related news','pedalcms'),
                        'name'          => 'news_tag',
                        'type'          => 'taxonomy',
                        'instructions'  => __('The tag that should associate posts with this program.','pedalcms'),
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
                        'label'         => __('Number of Posts','pedalcms'),
                        'name'          => 'news_num_posts',
                        'type'          => 'number',
                        'instructions'  => __('Number of posts to show on this subpage. Set to -1 to show all.','pedalcms'),
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
                        'label'         => __('Show link to all posts?','pedalcms'),
                        'name'          => 'news_show_all_link',
                        'type'          => 'true_false',
                        'instructions'  => __('Link to the tag archive view at the bottom of the list?','pedalcms'),
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
                        'label'        => __('Featured Posts','pedalcms'),
                        'name'         => 'news_featured_posts',
                        'type'         => 'post_object',
                        'instructions' => __('Select posts to keep at the top of the news subpage.','pedalcms'),
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
                        'label'         => _x('Lead Content', 'News','pedalcms'),
                        'name'          => 'news_lead',
                        'type'          => 'wysiwyg',
                        'instructions'  => __('Content to appear at the top of the page, before the posts.','pedalcms'),
                        'default_value' => '',
                        'tabs'          => 'all',
                        'toolbar'       => 'full',
                        'media_upload'  => 1,
                        'delay'         => 1,
                    ]
                ]
            ]
        ];

    }

    public function setup_hooks(): void {
        add_action('pre_get_posts', [static::class, 'update_sort_order']);
        add_action('wp_after_insert_post', [static::class, 'save_terms'], 10, 2);
    }

    /**
     * Changes the sort order for Programs.
     *
     * Called on filter: pre_get_posts
     *
     * @since 0.1.0
     *
     * @param WP_Query $query The current WP_Query
     * @return void
     */
    public static function update_sort_order(\WP_Query $query): void {
        $update_order =
            $query->is_main_query() &&
            !is_admin() &&
            !$query->get('orderby') &&
            $query->is_post_type_archive(self::POST_TYPE);

        if ($update_order) {
            $query->set('order', 'ASC');
            $query->set('orderby', 'title');
        }

        return;
    }

    public static function save_terms($post_id, $post) {
        if ($post->post_type === self::POST_TYPE) {
            Department::save_terms($post);
        }
    }

    /**
     * Get the news posts for a given program by related tag.
     *
     * Meta field news_tag must be set first.
     *
     * @since 0.1.0
     *
     * @param mixed $program Program to check for news posts. Either ID or WP_Post.
     * @param array $not_in List of ids to exclude from the results. Defaults to none.
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
     * Returns the full URL for a given program action.
     *
     * Will check for a local program override before attempting to build it from
     * the plugin wide pattern setting.
     *
     * @since 0.1.0
     *
     * @param string $action The name of the action.
     * @param mixed $program The ID of the program or a WP_Post object. Defaults to the current program.
     * @return string The URL of the program action.
     */
    public static function get_action_link(string $action, $program = null): string {
        $program = get_post($program);

        // Check for a local override.
        $url = get_field('url_' . $action, $program);

        if ($url) {
            return $url;
        }

        $url = \PedalCMS\Core\Plugin::get_option('program_url_' . $action);

        if ($url) {
            $url = str_replace(
                ['{$program_guid}', '{$program_slug}'],
                [get_field('program_guid', $program), $program->post_name],
                $url
            );

            return $url;
        }

        return '';
    }

    /**
     * Gets a list of application deadlines based on override hierarchy.
     *
     * Hierarchy is Program, College, Program Type, Global.
     *
     * @since 0.1.0
     *
     * @param mixed $program Program to check for news posts. Either ID or WP_Post. Defaults to current program.
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
        $deadlines = get_field('pdl_program_application_deadlines', 'option');
        if (is_array($deadlines)) {
            return $deadlines;
        }

        return [];
    }

    /**
     * Initializes the subpage manager and adds builtin subpages.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public static function setup_subpage_manager() {
        self::setup_subpages();
        self::$subpage_manager = new SubpageManager(Program::POST_TYPE);

        do_action('pdl/register_subpages', Program::POST_TYPE);

        foreach(Program::$subpages as $slug => $args) {
            $subpage = new Subpage($slug, $args);
            self::$subpage_manager->add_subpage($subpage);
        }
    }

    /**
     * Returns the subpage manager.
     *
     * @since 0.1.0
     *
     * @return SubpageManager The program subpage manager.
     */
    public static function subpage_manager() {
        return self::$subpage_manager;
    }
}
