<?php

namespace InvisibleUs\Programs;

/**
 * Program Subpage class stores settings for Cost.
 * 
 * @version 0.1.0
 * @package NVISPrograms
 * @since 0.1.0
 */
class CostProgramSubpage {
    public string $slug = 'cost';
    public string $title = 'Cost';

    public array $fields = [
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
            'key'           => 'field_61327ef17bf0d',
            'label'         => 'Cost Content',
            'name'          => 'cost_content',
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
