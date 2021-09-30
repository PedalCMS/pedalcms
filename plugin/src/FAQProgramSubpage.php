<?php

namespace InvisibleUs\Programs;

class FAQProgramSubpage {
    public string $slug = 'faqs';
    public string $title = 'FAQs';

    public array $fields = [
        [
            'key'       => 'field_61118a94cb6c1',
            'label'     => 'FAQs',
            'type'      => 'tab',
            'placement' => 'top',
            'endpoint'  => 0,
        ],
        [
            'key'           => 'field_61118aa8cb6c2',
            'label'         => 'Show FAQs Section?',
            'name'          => 'show_faqs_section',
            'type'          => 'true_false',
            'instructions'  => '',
            'message'       => '',
            'default_value' => true,
            'ui'            => 1,
            'ui_on_text'    => '',
            'ui_off_text'   => '',
        ],
        [
            'key'           => 'field_6113d61abfe26',
            'label'         => 'Group FAQs by category?',
            'name'          => 'faqs_by_category',
            'type'          => 'true_false',
            'instructions'  => '',
            'message'       => '',
            'default_value' => true,
            'ui'            => 1,
            'ui_on_text'    => '',
            'ui_off_text'   => '',
        ],
        [
            'key'           => 'field_6112760bd4b75',
            'label'         => 'FAQs Lead Content',
            'name'          => 'faqs_lead',
            'type'          => 'wysiwyg',
            'instructions'  => '',
            'default_value' => '',
            'tabs'          => 'all',
            'toolbar'       => 'full',
            'media_upload'  => 1,
            'delay'         => 1,
        ],
        [
            'key'          => 'field_61118c758e01f',
            'label'        => 'Related FAQs',
            'name'         => 'related_faqs',
            'type'         => 'relationship',
            'instructions' => '',
            'post_type'    => [
                0 => 'nvis_faq',
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
        ],
    ];
}
