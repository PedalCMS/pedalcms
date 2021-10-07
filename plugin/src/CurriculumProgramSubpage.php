<?php

namespace InvisibleUs\Programs;

/**
 * Program Subpage class stores settings for Curriculum.
 *
 * @package NVISPrograms
 * @subpackage ProgramSubpages
 * @since 0.1.0
 */
class CurriculumProgramSubpage {
    public string $slug = 'curriculum';
    public string $title = 'Curriculum';

    public array $fields = [
        [
            'key'       => 'field_615f0febd18a0',
            'label'     => 'Curriculum',
            'type'      => 'tab',
            'placement' => 'top',
            'endpoint'  => 0,
        ],
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
    ];
}
