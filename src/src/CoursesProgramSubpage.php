<?php

namespace InvisibleUs\Programs;

class CoursesProgramSubpage {
    public $slug = 'careers';
    public $title = 'Careers';

    public $fields = [
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
