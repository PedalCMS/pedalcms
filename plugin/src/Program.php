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
     * 
     * @since 0.1.0
     * 
     * @var string
     */
    public const POST_TYPE = 'nvis_program';

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
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
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
            'name'                     => _x( 'Programs', 'post type general name', 'nvis-program-pages' ),
            'singular_name'            => _x( 'Program', 'post type singular name', 'nvis-program-pages' ),
            'add_new_item'             => __( 'Add New Program', 'nvis-program-pages' ),
            'edit_item'                => __( 'Edit Program', 'nvis-program-pages' ),
            'new_item'                 => __( 'New Program', 'nvis-program-pages' ),
            'view_item'                => __( 'View Program', 'nvis-program-pages' ),
            'view_items'               => __( 'View Programs', 'nvis-program-pages' ),
            'search_items'             => __( 'Search Programs', 'nvis-program-pages' ),
            'not_found'                => __( 'No programs found.', 'nvis-program-pages' ),
            'not_found_in_trash'       => __( 'No programs found in Trash.', 'nvis-program-pages' ),
            'parent_item_colon'        => __( 'Parent Program:', 'nvis-program-pages' ),
            'all_items'                => __( 'All Programs', 'nvis-program-pages' ),
            'archives'                 => __( 'Program Archives', 'nvis-program-pages' ),
            'attributes'               => __( 'Program Attributes', 'nvis-program-pages' ),
            'insert_into_item'         => __( 'Insert into program', 'nvis-program-pages' ),
            'uploaded_to_this_item'    => __( 'Uploaded to this program', 'nvis-program-pages' ),
            'filter_items_list'        => __( 'Filter programs list', 'nvis-program-pages' ),
            'items_list_navigation'    => __( 'Programs list navigation', 'nvis-program-pages' ),
            'items_list'               => __( 'Programs list', 'nvis-program-pages' ),
            'item_published'           => __( 'Program published.', 'nvis-program-pages' ),
            'item_published_privately' => __( 'Program published privately.', 'nvis-program-pages' ),
            'item_reverted_to_draft'   => __( 'Program reverted to draft.', 'nvis-program-pages' ),
            'item_scheduled'           => __( 'Program scheduled.', 'nvis-program-pages' ),
            'item_updated'             => __( 'Program updated.', 'nvis-program-pages' ),
            'item_link'                => _x( 'Program Link', 'navigation link block title', 'nvis-program-pages' ),
            'item_link_description'    => _x( 'A link to a program.', 'navigation link block description', 'nvis-program-pages' ),
        ];
    }

    protected function setup_field_group() {
        $field_group = [
            'key'         => 'group_61118a19b2e4c',
            'title'       => _x('Program Info', 'field group title','nvis-program-pages'),
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
                    'label'     => __('Main','nvis-program-pages'),
                    'type'      => 'tab',
                    'placement' => 'top',
                    'endpoint'  => 0,
                ],
                [
                    'key'          => 'field_6112773d640f4',
                    'label'        => __('Program GUID','nvis-program-pages'),
                    'name'         => 'program_guid',
                    'type'         => 'text',
                    'instructions' => 'The globally unique identifier for the program. Typically, used campus-wide across systems.',
                ],
                [
                    'key'           => 'field_611279af182d2',
                    'label'         => __('College','nvis-program-pages'),
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
                    'label'         => __('Program Type','nvis-program-pages'),
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
                    'label'         => __('Instruction Mode','nvis-program-pages'),
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
                    'label'         => __('Prerequisites','nvis-program-pages'),
                    'name'          => 'prerequisites',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'message'       => '',
                    'default_value' => true,
                    'ui'            => 1,
                ],
                [
                    'key'           => 'field_6112738ed4b70',
                    'label'         => __('Overview Content','nvis-program-pages'),
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
                    'label'        => __('Request Info URL','nvis-program-pages'),
                    'name'         => 'url_request_info',
                    'type'         => 'url',
                    'instructions' => __('Overrides the global pattern for Request Info URLs.','nvis-program-pages'),
                    'placeholder'  => '',
                ],
                [
                    'key'          => 'field_61127d728fbcc',
                    'label'        => __('Apply Now URL','nvis-program-pages'),
                    'name'         => 'url_apply_now',
                    'type'         => 'url',
                    'instructions' => __('Overrides the global pattern for Apply Now URLs.','nvis-program-pages'),
                    'placeholder'  => '',
                ],
                [
                    'key'          => 'field_61127d948fbcd',
                    'label'        => __('Contact Us URL','nvis-program-pages'),
                    'name'         => 'url_contact_us',
                    'type'         => 'url',
                    'instructions' => __('Overrides the global pattern for Contact Us URLs.','nvis-program-pages'),
                    'placeholder'  => '',
                ],
                [
                    'key'           => 'field_6138d5c7722ca',
                    'label'         => __('Show Application Deadlines?','nvis-program-pages'),
                    'name'          => 'show_application_deadlines',
                    'type'          => 'true_false',
                    'instructions'  => '',
                    'message'       => '',
                    'default_value' => true,
                    'ui'            => 1,
                ],
                [
                    'key'          => 'field_613a6d0cce1eb',
                    'label'        => __('Application Deadlines','nvis-program-pages'),
                    'name'         => 'application_deadlines',
                    'type'         => 'repeater',
                    'instructions' => __('Leave blank to inherit.','nvis-program-pages'),
                    'collapsed'    => 'field_61156b777d403',
                    'layout'       => 'block',
                    'button_label' => _x('Add Deadline', 'new deadline button label','nvis-program-pages'),
                    'sub_fields'   => [
                        [
                            'key'          => 'field_61156b777d403',
                            'label'        => __('Deadline Label','nvis-program-pages'),
                            'name'         => 'deadline_label',
                            'type'         => 'text',
                            'instructions' => '',
                            'required'     => 1,
                            'placeholder'  => _x('Fall, Spring, etc.', 'deadline label field placeholder', 'nvis-program-pages'),
                            'maxlength'    => '',
                        ],
                        [
                            'key'          => 'field_61156bbe7d404',
                            'label'        => __('Deadline Info','nvis-program-pages'),
                            'name'         => 'deadline_info',
                            'type'         => 'text',
                            'instructions' => '',
                            'placeholder'  => _x('e.g. June 24th', 'deadline info field placeholder', 'nvis-program-pages'),
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
                    'label'        => __('Program Contacts','nvis-program-pages'),
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
        ];

        $field_group['fields'] = array_merge(
            $field_group['fields'],
            Program::$subpage_manager->get_enabled_subpage_fields()
        );

        $this->field_groups[] = $field_group;
    }

    protected static function setup_subpages() {
        self::$subpages = [
            'index' => [
                'title' => _x('Overview', 'Proper subpage title','nvis-program-pages'),
                'order' => -1,
                'builtin' => true
            ],
            'curriculum' => [
                'title' => _x('Curriculum','Proper subpage title','nvis-program-pages'),
                'order' => 10,
                'builtin' => true,
                'fields' => [
                    [
                        'key'           => 'field_6112835dfeb44',
                        'label'         => __('Show Curriculum Section?','nvis-program-pages'),
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
                        'label'         => _x('Lead Content', 'Curriculum','nvis-program-pages'),
                        'name'          => 'curriculum_lead',
                        'type'          => 'wysiwyg',
                        'instructions'  => __('This content goes before the list of curriculum sections.','nvis-program-pages'),
                        'default_value' => '',
                        'tabs'          => 'all',
                        'toolbar'       => 'full',
                        'media_upload'  => 1,
                        'delay'         => 1,
                    ],
                    [
                        'key'          => 'field_615f0c5a22deb',
                        'label'        => __('Curriculum Sections','nvis-program-pages'),
                        'name'         => 'curriculum_sections',
                        'type'         => 'repeater',
                        'instructions' => '',
                        'collapsed'    => 'field_615f0c8022dec',
                        'layout'       => 'block',
                        'button_label' => _x('Add Section','New section button label','nvis-program-pages'),
                        'sub_fields'   => [
                            [
                                'key'          => 'field_615f0c8022dec',
                                'label'        => __('Section Title','nvis-program-pages'),
                                'name'         => 'section_title',
                                'type'         => 'text',
                                'instructions' => '',
                                'placeholder'  => __('Math Requirements, etc.','nvis-program-pages'),
                                'prepend'      => '',
                                'append'       => '',
                                'maxlength'    => '',
                            ],
                            [
                                'key'               => 'field_615f0cd622ded',
                                'label'             => __('Section Content','nvis-program-pages'),
                                'name'              => 'section_content',
                                'type'              => 'wysiwyg',
                                'instructions'      => __('Some preamble or instructions about the courses below. For example, "Choose two of the following."','nvis-program-pages'),
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
                                'label'        => __('Section Courses','nvis-program-pages'),
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
                'title' => _x('Careers', 'Proper subpage title','nvis-program-pages'),
                'aria_label' => __('Careers related to the current program','nvis-program-pages'),
                'order' => 20,
                'builtin' => true,
                'fields' => [
                    [
                        'key'           => 'field_61118a6ecb6c0',
                        'label'         => __('Show Careers Section?','nvis-program-pages'),
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
                        'label'         => _x('Lead Content', 'Careers','nvis-program-pages'),
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
                        'label'        => __('Related Careers','nvis-program-pages'),
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
                'title' => _x('Faculty & Staff','Proper subpage title','nvis-program-pages'),
                'aria_label' => __('Faculty & staff related to the current program','nvis-program-pages'),
                'order' => 30,
                'builtin' => true,
                'fields' => [
                    [
                        'key'           => 'field_613b63fa499ce',
                        'label'         => __('Show Faculty & Staff Section?','nvis-program-pages'),
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
                        'label'         => _x('Lead Content', 'Faculty & Staff','nvis-program-pages'),
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
                        'label'         => __('Group by category?','nvis-program-pages'),
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
                        'label'        => __('Related Faculty & Staff','nvis-program-pages'),
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
                'title' => _x('Cost','Proper subpage title','nvis-program-pages'),
                'order' => 40,
                'builtin' => true,
                'fields' => [
                    [
                        'key'           => 'field_6124eebb8a99e',
                        'label'         => __('Show Cost Section?','nvis-program-pages'),
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
                        'label'         => __('Estimated Cost Label','nvis-program-pages'),
                        'name'          => 'estimated_cost_label',
                        'type'          => 'text',
                        'instructions'  => '',
                        'placeholder'   => _x('Estimated Cost', 'field placeholder','nvis-program-pages'),
                    ],
                    [
                        'key'               => 'field_6178492a5496c',
                        'label'             => _x('Estimated Cost', 'field label','nvis-program-pages'),
                        'name'              => 'estimated_cost',
                        'type'              => 'text',
                        'instructions'      => __('Leave blank to omit this field.','nvis-program-pages'),
                    ],
                    [
                        'key'           => 'field_61327ef17bf0d',
                        'label'         => __('Cost Content','nvis-program-pages'),
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
                'title' => _x('How to Apply','Proper subpage title','nvis-program-pages'),
                'order' => 50,
                'builtin' => true,
                'fields' => [
                    [
                        'key'           => 'field_611d69fb7f47f',
                        'label'         => __('Show Apply Section?','nvis-program-pages'),
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
                        'label'         => __('Apply Content','nvis-program-pages'),
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
                'title' => _x('FAQs','Proper subpage title','nvis-program-pages'),
                'aria_label' => __('FAQs related to the current program','nvis-program-pages'),
                'order' => 60,
                'builtin' => true,
                'fields' => [
                    [
                        'key'           => 'field_61118aa8cb6c2',
                        'label'         => __('Show FAQs Section?','nvis-program-pages'),
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
                        'label'         => __('Group FAQs by category?','nvis-program-pages'),
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
                        'label'         => _x('Lead Content', 'FAQs','nvis-program-pages'),
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
                        'label'        => __('Related FAQs','nvis-program-pages'),
                        'name'         => 'related_faqs_list',
                        'type'         => 'repeater',
                        'instructions' => '',
                        'collapsed'    => 'field_61701ac036063',
                        'layout'       => 'row',
                        'button_label' => _x('Add Question', 'new question button label','nvis-program-pages'),
                        'sub_fields'   => [
                            [
                                'key'           => 'field_61701ac036063',
                                'label'         => __('FAQ Type','nvis-program-pages'),
                                'name'          => 'faq_type',
                                'type'          => 'radio',
                                'instructions'  => __('Select the type of FAQ you would like to add.','nvis-program-pages'),
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
                                'label'             => _x('Global FAQ', 'faqs relevant to all programs','nvis-program-pages'),
                                'name'              => 'faq_post',
                                'type'              => 'post_object',
                                'instructions'      => __('Select the global question.','nvis-program-pages'),
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
                                'label'             => __('Question','nvis-program-pages'),
                                'name'              => 'question',
                                'type'              => 'text',
                                'instructions'      => __('Enter the question text.','nvis-program-pages'),
                                'placeholder'       => _x('What is the question?', 'question field placeholder','nvis-program-pages'),
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
                                'label'             => __('Answer','nvis-program-pages'),
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
                                'label'             => __('Category','nvis-program-pages'),
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
                'title' => _x('News','Proper subpage title','nvis-program-pages'),
                'aria_label' => __('News related to the current program','nvis-program-pages'),
                'order' => 70,
                'builtin' => true,
                'fields' => [
                    [
                        'key'           => 'field_611fdfdc20be6',
                        'label'         => __('Show News Section?','nvis-program-pages'),
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
                        'label'         => _x('News Tag', 'tag of related news','nvis-program-pages'),
                        'name'          => 'news_tag',
                        'type'          => 'taxonomy',
                        'instructions'  => __('The tag that should associate posts with this program.','nvis-program-pages'),
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
                        'label'         => __('Number of Posts','nvis-program-pages'),
                        'name'          => 'news_num_posts',
                        'type'          => 'number',
                        'instructions'  => __('Number of posts to show on this subpage. Set to -1 to show all.','nvis-program-pages'),
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
                        'label'         => __('Show link to all posts?','nvis-program-pages'),
                        'name'          => 'news_show_all_link',
                        'type'          => 'true_false',
                        'instructions'  => __('Link to the tag archive view at the bottom of the list?','nvis-program-pages'),
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
                        'label'        => __('Featured Posts','nvis-program-pages'),
                        'name'         => 'news_featured_posts',
                        'type'         => 'post_object',
                        'instructions' => __('Select posts to keep at the top of the news subpage.','nvis-program-pages'),
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
                        'label'         => _x('Lead Content', 'News','nvis-program-pages'),
                        'name'          => 'news_lead',
                        'type'          => 'wysiwyg',
                        'instructions'  => __('Content to appear at the top of the page, before the posts.','nvis-program-pages'),
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
