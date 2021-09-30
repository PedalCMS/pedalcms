<?php

namespace InvisibleUs\Programs;

/**
 * Program Subpage class stores settings for Faculty & Staff.
 * 
 * @version 0.1.0
 * @package nvis-programs
 * @since 0.1.0
 */
class FacultyStaffProgramSubpage {
    public string $slug = 'faculty-staff';
    public string $title = 'Faculty & Staff';

    public array $fields = [
        [
            'key'       => 'field_613b63eae979f',
            'label'     => 'People',
            'type'      => 'tab',
            'placement' => 'top',
            'endpoint'  => 0,
        ],
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
    ];
}
