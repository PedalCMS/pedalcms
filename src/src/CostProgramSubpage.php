<?php

namespace InvisibleUs\Programs;

class CostProgramSubpage {
    public $slug = 'cost';
    public $title = 'Cost';

    public $fields = [
        [
            'key'       => 'field_611d69e77f47e',
            'label'     => 'Cost',
            'type'      => 'tab',
            'placement' => 'top',
            'endpoint'  => 0,
        ],
        [
            'key'           => 'field_6124eebb8a99e',
            'label'         => 'Show Cost Section?',
            'name'          => 'show_cost_section',
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
