<?php

namespace InvisibleUs\Programs;

/**
 * Program Subpage class stores settings for Careers.
 * 
 * @package NVISPrograms
 * @subpackage ProgramSubpages
 * @since 0.1.0
 */
class CareersProgramSubpage {
    public string $slug = 'careers';
    public string $title = 'Careers';

    public array $fields = [
        [
            'key'       => 'field_61118a3dcb6bf',
            'label'     => 'Careers',
            'type'      => 'tab',
            'placement' => 'top',
            'endpoint'  => 0,
        ],
        [
            'key'           => 'field_61118a6ecb6c0',
            'label'         => 'Show Careers Section?',
            'name'          => 'show_careers_section',
            'type'          => 'true_false',
            'instructions'  => '',
            'message'       => '',
            'default_value' => true,
            'ui'            => 1,
            'ui_on_text'    => '',
            'ui_off_text'   => '',
        ],
        [
            'key'           => 'field_611275a9d4b74',
            'label'         => 'Careers Lead Content',
            'name'          => 'careers_lead',
            'type'          => 'wysiwyg',
            'instructions'  => '',
            'default_value' => '',
            'tabs'          => 'all',
            'toolbar'       => 'full',
            'media_upload'  => 1,
            'delay'         => 1,
        ],
        [
            'key'          => 'field_6112754dd4b73',
            'label'        => 'Related Careers',
            'name'         => 'related_careers',
            'type'         => 'relationship',
            'instructions' => '',
            'post_type'    => [
                0 => 'nvis_career',
            ],
            'taxonomy' => '',
            'filters'  => [
                0 => 'search',
                1 => 'taxonomy',
            ],
            'elements'      => '',
            'min'           => '',
            'max'           => '',
            'return_format' => 'object',
        ]
    ];
}
