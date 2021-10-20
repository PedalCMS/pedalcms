<?php

namespace InvisibleUs\Programs;

/**
 * Program Subpage class stores settings for FAQs.
 *
 * @package NVISPrograms
 * @subpackage ProgramSubpages
 * @since 0.1.0
 */
class FAQProgramSubpage {
    public string $slug = 'faqs';
    public string $title = 'FAQs';

    public array $fields = [
        [
            'key'       => 'field_61118a94cb6c1',
            'label'     => 'FAQs',
            'type'      => 'tab',
            'placement' => 'top',
            'endpoint'  => 0,
        ],
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
    ];
}
