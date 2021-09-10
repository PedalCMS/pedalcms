<?php

namespace InvisibleUs\Programs;

class FacultyStaffProgramSubpage {
    public $slug = 'faculty-staff';
    public $title = 'Faculty & Staff';

    public $fields = [
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
    ];
}
