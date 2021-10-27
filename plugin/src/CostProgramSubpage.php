<?php

namespace InvisibleUs\Programs;

/**
 * Program Subpage class stores settings for Cost.
 *
 * @package NVISPrograms
 * @subpackage ProgramSubpages
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
        ],[
            'key'           => 'field_617848545496b',
            'label'         => 'Estimated Cost Label',
            'name'          => 'estimated_cost_label',
            'type'          => 'text',
            'instructions'  => '',
            'placeholder'   => 'Estimated Cost',
        ],
        [
            'key'               => 'field_6178492a5496c',
            'label'             => 'Estimated Cost',
            'name'              => 'estimated_cost',
            'type'              => 'text',
            'instructions'      => 'Leave blank to omit this field.'
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
