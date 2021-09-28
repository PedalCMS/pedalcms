<?php

namespace InvisibleUs\Programs;

class ApplyProgramSubpage {
    public $slug = 'apply';
    public $title = 'How to Apply';

    public $fields = [
        [
            'key'       => 'field_611d6bb9199d7',
            'label'     => 'Apply',
            'type'      => 'tab',
            'placement' => 'top',
            'endpoint'  => 0,
        ],
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
    ];
}
