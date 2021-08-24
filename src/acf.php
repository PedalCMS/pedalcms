<?php

namespace InvisibleUs\Programs;

add_action('plugins_loaded', __NAMESPACE__ . '\maybe_load_acf');
add_action('acf/init', __NAMESPACE__ . '\load_fields');

function maybe_load_acf() {
    // If ACF is already loaded, we can bail.
    if (class_exists('ACF')) {
        return;
    }

    $subpath = '/src/acf/';
    define('NVISP_ACF_PATH', NVIS_PROGRAMS_PATH . $subpath);
    define('NVISP_ACF_URL', NVIS_PROGRAMS_URL . $subpath);

    include_once(NVISP_ACF_PATH . 'acf.php');

    add_filter('acf/settings/url', __NAMESPACE__ . '\acf_settings_url');
    add_filter('acf/settings/show_admin', '__return_false');
}

function acf_settings_url(string $url) {
    return NVISP_ACF_URL;
}

function load_fields() {
    $field_groups = [
        get_plugin_acf_fields(),
        get_program_type_acf_fields(),
        get_taxonomy_app_deadlines_acf_fields()
    ];

    foreach ($field_groups as $group) {
        acf_add_local_field_group($group);
    }
}

function get_plugin_acf_fields(): array {
    $subpages = get_subpages();
    $def_vals = [];

    // Remove the first subpage (Overview). It is not optional.
    array_shift($subpages);

    return [
        'key' => 'group_6113a9e72073e',
        'title' => 'WP Program Pages Settings',
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'wp-program-pages-settings',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'fields' => [
            [
                'key' => 'field_6123e2fca5e15',
                'label' => 'Enable Program Subpages',
                'name' => 'enable_program_subpages',
                'type' => 'checkbox',
                'instructions' => '',
                'choices' => $subpages,
                'allow_custom' => 0,
                'default_value' => array_pad($def_vals, count($subpages), 1),
                'layout' => 'vertical',
                'toggle' => 1,
                'return_format' => 'value',
                'save_custom' => 0,
            ],
            [
                'key' => 'field_6113aaf181bb3',
                'label' => 'Request Info URL',
                'name' => 'nvis_url_request_info',
                'type' => 'url',
                'instructions' => 'Enter a URL pattern to create unique request info URLs for each program. You can use the following tags: {$program_guid} {$program_slug}',
                'placeholder' => '',
            ],
            [
                'key' => 'field_61156396f5e83',
                'label' => 'Apply Now URL',
                'name' => 'nvis_url_apply_now',
                'type' => 'url',
                'instructions' => 'Enter a URL pattern to create unique apply now URLs for each program. You can use the following tags: {$program_guid} {$program_slug}',
                'placeholder' => '',
            ],
            [
                'key' => 'field_611563eef5e84',
                'label' => 'Contact URL',
                'name' => 'nvis_url_contact',
                'type' => 'url',
                'instructions' => 'Enter a URL pattern to create unique contact URLs for each program. You can use the following tags: {$program_guid} {$program_slug}',
                'placeholder' => '',
            ],
            get_acf_app_deadlines_field(
                'Application Deadlines',
                'nvis_application_deadlines',
                '',
                'field_61156b547d402'
            )
        ]
    ];
}

function get_program_type_acf_fields(): array {
    $group = [
        'key' => 'group_61118a19b2e4c',
        'title' => 'Program Info',
        'description' => 'All fields related to programs and their subpages.',
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'nvis_program',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'seamless',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'fields' => [
            get_acf_tab_field('Main', 'field_6112749bd4b71'),
            [
                'key' => 'field_6112773d640f4',
                'label' => 'Program GUID',
                'name' => 'program_guid',
                'type' => 'text',
                'instructions' => 'The globally unique identifier for the program. Typically, used campus-wide across systems.',
            ],
            [
                'key' => 'field_611279af182d2',
                'label' => 'College',
                'name' => 'college',
                'type' => 'taxonomy',
                'instructions' => '',
                'required' => 1,
                'taxonomy' => 'nvis_program_college',
                'field_type' => 'select',
                'allow_null' => 0,
                'add_term' => 0,
                'save_terms' => 1,
                'load_terms' => 1,
                'return_format' => 'object',
                'multiple' => 0,
            ],
            [
                'key' => 'field_61127c46a8faf',
                'label' => 'Program Type',
                'name' => 'program_type',
                'type' => 'taxonomy',
                'instructions' => '',
                'required' => 1,
                'taxonomy' => 'nvis_program_type',
                'field_type' => 'radio',
                'allow_null' => 0,
                'add_term' => 0,
                'save_terms' => 1,
                'load_terms' => 1,
                'return_format' => 'object',
                'multiple' => 0,
            ],
            [
                'key' => 'field_61127a1f182d4',
                'label' => 'Delivery Format',
                'name' => 'delivery_format',
                'type' => 'taxonomy',
                'instructions' => '',
                'taxonomy' => 'nvis_program_format',
                'field_type' => 'radio',
                'allow_null' => 0,
                'add_term' => 0,
                'save_terms' => 1,
                'load_terms' => 1,
                'return_format' => 'object',
                'multiple' => 0,
            ],
            get_acf_true_false_field(
                'Prerequisites',
                'prerequisites',
                '',
                'field_61128ea8b1920'
            ),
            [
                'key' => 'field_6112738ed4b70',
                'label' => 'Overview Content',
                'name' => 'overview_content',
                'type' => 'wysiwyg',
                'instructions' => '',
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ],
            [
                'key' => 'field_61127d078fbcb',
                'label' => 'Request Info URL',
                'name' => 'url_request_info',
                'type' => 'url',
                'instructions' => 'Overrides the global pattern for Request Info URLs.',
                'placeholder' => '',
            ],
            [
                'key' => 'field_61127d728fbcc',
                'label' => 'Apply Now URL',
                'name' => 'url_apply_now',
                'type' => 'url',
                'instructions' => 'Overrides the global pattern for Apply Now URLs.',
                'placeholder' => '',
            ],
            get_acf_app_deadlines_field(
                'Application Deadlines',
                'application_deadlines',
                'Leave blank to inherit.',
                'field_612405570ceb7'
            ),
            [
                'key' => 'field_61127d948fbcd',
                'label' => 'Contact Us URL',
                'name' => 'url_contact_us',
                'type' => 'url',
                'instructions' => 'Overrides the global pattern for Contact Us URLs.',
                'placeholder' => '',
            ],
            [
                'key' => 'field_611276e3640f3',
                'label' => 'Program Contacts',
                'name' => 'related_contacts',
                'type' => 'relationship',
                'instructions' => '',
                'post_type' => [
                    0 => 'nvis_person',
                ],
                'taxonomy' => '',
                'filters' => [
                    0 => 'search',
                ],
                'elements' => [
                    0 => 'featured_image',
                ],
                'min' => '',
                'max' => '',
                'return_format' => 'object',
            ]
        ]
    ];

    $opt_fields = [
        'careers' => [
            get_acf_tab_field('Careers', 'field_61118a3dcb6bf'),
            get_acf_true_false_field(
                'Show Careers Section?',
                'show_careers_section',
                '',
                'field_61118a6ecb6c0'
            ),
            get_acf_lead_content_field(
                'Careers Lead Content',
                'careers_lead',
                '',
                'field_611275a9d4b74'
            ),
            [
                'key' => 'field_6112754dd4b73',
                'label' => 'Related Careers',
                'name' => 'related_careers',
                'type' => 'relationship',
                'instructions' => '',
                'post_type' => [
                    0 => 'nvis_career',
                ],
                'taxonomy' => '',
                'filters' => [
                    0 => 'search',
                    1 => 'taxonomy',
                ],
                'elements' => '',
                'min' => '',
                'max' => '',
                'return_format' => 'object',
            ],
        ],
        'faqs' => [
            get_acf_tab_field('FAQs', 'field_61118a94cb6c1'),
            get_acf_true_false_field(
                'Show FAQs Section?',
                'show_faqs_section',
                '',
                'field_61118aa8cb6c2'
            ),
            get_acf_true_false_field(
                'Group FAQs by category?',
                'faqs_by_category',
                '',
                'field_6113d61abfe26'
            ),
            get_acf_lead_content_field(
                'FAQs Lead Content',
                'faqs_lead',
                '',
                'field_6112760bd4b75'
            ),
            [
                'key' => 'field_61118c758e01f',
                'label' => 'Related FAQs',
                'name' => 'related_faqs',
                'type' => 'relationship',
                'instructions' => '',
                'post_type' => [
                    0 => 'nvis_faq',
                ],
                'taxonomy' => '',
                'filters' => [
                    0 => 'search',
                    1 => 'taxonomy',
                ],
                'elements' => '',
                'min' => '',
                'max' => '',
                'return_format' => 'object',
            ],
        ],
        'courses' => [
            get_acf_tab_field('Courses', 'field_6112591dbe6dd'),
            get_acf_true_false_field(
                'Show Courses Section?',
                'show_courses_section',
                '',
                'field_6112835dfeb44'
            ),
            get_acf_lead_content_field(
                'Courses Lead Content',
                'courses_lead',
                '',
                'field_611274eed4b72'
            ),
        ],
        'cost' => [
            get_acf_tab_field('Cost', 'field_611d69e77f47e'),
            get_acf_true_false_field(
                'Show Cost Section?',
                'show_cost_section',
                '',
                'field_6124eebb8a99e'
            ),
            [
                'key' => 'field_611d6a3a7f480',
                'label' => 'Cost Content',
                'name' => 'cost_content',
                'type' => 'wysiwyg',
                'instructions' => '',
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 1,
            ],
        ],
        'apply' => [
            get_acf_tab_field('Apply', 'field_611d6bb9199d7'),
            get_acf_true_false_field(
                'Show Apply Section?',
                'show_apply_section',
                '',
                'field_611d69fb7f47f'
            ),
            [
                'key' => 'field_611d6bfe199d9',
                'label' => 'Apply Content',
                'name' => 'apply_content',
                'type' => 'wysiwyg',
                'instructions' => '',
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 1,
            ],
        ],
        'news' => [
            get_acf_tab_field('News', 'field_611fdfc220be4'),
            get_acf_true_false_field(
                'Show News Section?',
                'show_news_section',
                '',
                'field_611fdfdc20be6'
            ),
            [
                'key' => 'field_611fe01c20be7',
                'label' => 'News Tag',
                'name' => 'news_tag',
                'type' => 'taxonomy',
                'instructions' => 'The tag that should associate posts with this program.',
                'taxonomy' => 'post_tag',
                'field_type' => 'select',
                'allow_null' => 1,
                'add_term' => 1,
                'save_terms' => 0,
                'load_terms' => 0,
                'return_format' => 'id',
                'multiple' => 0,
                'wrapper' => [
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ],
            ],
            [
                'key' => 'field_6124f029ff016',
                'label' => 'Number of Posts',
                'name' => 'news_num_posts',
                'type' => 'number',
                'instructions' => 'Number of posts to show on this subpage. Set to -1 to show all.',
                'default_value' => 10,
                'placeholder' => '10',
                'min' => -1,
                'step' => 1,
                'wrapper' => [
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ],
            ],
            [
                'key' => 'field_6124f184ff017',
                'label' => 'Show link to all posts?',
                'name' => 'news_show_all_link',
                'type' => 'true_false',
                'instructions' => 'Link to the tag archive view at the bottom of the list?',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => [
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ],
            ],
            get_acf_lead_content_field(
                'News Lead Content',
                'news_lead',
                '',
                'field_611fdfd220be5'
            )
        ]
    ];

    $enabled_subpages = get_field('enable_program_subpages', 'option');

    foreach ($opt_fields as $key => $opt_group) {
        if (in_array($key, $enabled_subpages)) {
            $group['fields'] = array_merge(
                $group['fields'],
                $opt_group
            );
        }
    }

    return $group;
}

function get_taxonomy_app_deadlines_acf_fields(): array {
    return [
        'key' => 'group_6123fad662541',
        'title' => 'Application Deadlines',
        'description' => '',
        'location' => [
            [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'nvis_program_type',
                ],
            ],
            [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'nvis_program_college',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
        'fields' => [
            get_acf_app_deadlines_field(
                'Override Application Deadlines',
                'application_deadlines',
                'Override application deadlines for all related programs. Must provide all deadlines.',
                'field_6123fae8f9946'
            )
        ],
    ];
}

function get_acf_tab_field(string $label, string $key): array {
    return [
        'key' => $key,
        'label' => $label,
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ];
}

function get_acf_true_false_field(string $label, string $name, string $instructions, string $key, bool $default = true) {
    return [
        'key' => $key,
        'label' => $label,
        'name' => $name,
        'type' => 'true_false',
        'instructions' => $instructions,
        'message' => '',
        'default_value' => $default,
        'ui' => 1,
        'ui_on_text' => '',
        'ui_off_text' => '',
    ];
}

function get_acf_lead_content_field(string $label, string $name, string $instructions, string $key): array {
    return [
        'key' => $key,
        'label' => $label,
        'name' => $name,
        'type' => 'wysiwyg',
        'instructions' => $instructions,
        'default_value' => '',
        'tabs' => 'all',
        'toolbar' => 'full',
        'media_upload' => 1,
        'delay' => 1,
    ];
}

function get_acf_app_deadlines_field(string $label, string $name, string $instructions, string $key): array {
    return [
        'key' => $key,
        'label' => $label,
        'name' => $name,
        'type' => 'repeater',
        'instructions' => $instructions,
        'collapsed' => 'field_61156b777d403',
        'layout' => 'block',
        'button_label' => 'Add Deadline',
        'sub_fields' => [
            [
                'key' => 'field_61156b777d403',
                'label' => 'Deadline Label',
                'name' => 'deadline_label',
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'placeholder' => 'Fall, Spring, etc.',
                'maxlength' => '',
            ],
            [
                'key' => 'field_61156bbe7d404',
                'label' => 'Deadline Info',
                'name' => 'deadline_info',
                'type' => 'text',
                'instructions' => '',
                'placeholder' => 'e.g. June 24th',
                'maxlength' => '',
            ],
        ],
    ];
}
