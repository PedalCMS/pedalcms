<?php

namespace InvisibleUs\Programs;

/**
 * Program Subpage class stores settings for Courses.
 * 
 * @package NVISPrograms
 * @since 0.1.0
 */
class CoursesProgramSubpage {
    public string $slug = 'courses';
    public string $title = 'Courses';

    public array $fields = [
        [
            'key'       => 'field_6112591dbe6dd',
            'label'     => 'Courses',
            'type'      => 'tab',
            'placement' => 'top',
            'endpoint'  => 0,
        ],
        [
            'key'           => 'field_6112835dfeb44',
            'label'         => 'Show Courses Section?',
            'name'          => 'show_courses_section',
            'type'          => 'true_false',
            'instructions'  => '',
            'message'       => '',
            'default_value' => true,
            'ui'            => 1,
            'ui_on_text'    => '',
            'ui_off_text'   => '',
        ],
        [
            'key'           => 'field_611274eed4b72',
            'label'         => 'Courses Lead Content',
            'name'          => 'courses_lead',
            'type'          => 'wysiwyg',
            'instructions'  => '',
            'default_value' => '',
            'tabs'          => 'all',
            'toolbar'       => 'full',
            'media_upload'  => 1,
            'delay'         => 1,
        ],
        [
            'key'          => 'field_612527fd6b84d',
            'label'        => 'Related Courses',
            'name'         => 'related_courses',
            'type'         => 'relationship',
            'instructions' => 'Connect all the courses related to this program.',
            'post_type'    => [
                0 => 'nvis_course',
            ],
            'filters' => [
                0 => 'search',
            ],
            'return_format' => 'object'
        ]
    ];
}
