<?php

namespace InvisibleUs\Programs;

class NewsProgramSubpage {
    public $slug = 'news';
    public $title = 'News';

    public $fields = [
        [
            'key'       => 'News',
            'label'     => 'field_611fdfc220be4',
            'type'      => 'tab',
            'placement' => 'top',
            'endpoint'  => 0,
        ],
        [
            'key'           => 'field_611fdfdc20be6',
            'label'         => 'Show News Section?',
            'name'          => 'show_news_section',
            'type'          => 'true_false',
            'instructions'  => '',
            'message'       => '',
            'default_value' => true,
            'ui'            => 1,
            'ui_on_text'    => '',
            'ui_off_text'   => '',
        ],
        [
            'key'           => 'field_611fe01c20be7',
            'label'         => 'News Tag',
            'name'          => 'news_tag',
            'type'          => 'taxonomy',
            'instructions'  => 'The tag that should associate posts with this program.',
            'taxonomy'      => 'post_tag',
            'field_type'    => 'select',
            'allow_null'    => 1,
            'add_term'      => 1,
            'save_terms'    => 0,
            'load_terms'    => 0,
            'return_format' => 'id',
            'multiple'      => 0,
            'wrapper'       => [
                'width' => '33',
                'class' => '',
                'id'    => '',
            ],
        ],
        [
            'key'           => 'field_6124f029ff016',
            'label'         => 'Number of Posts',
            'name'          => 'news_num_posts',
            'type'          => 'number',
            'instructions'  => 'Number of posts to show on this subpage. Set to -1 to show all.',
            'default_value' => 10,
            'placeholder'   => '10',
            'min'           => -1,
            'step'          => 1,
            'wrapper'       => [
                'width' => '33',
                'class' => '',
                'id'    => '',
            ],
        ],
        [
            'key'           => 'field_6124f184ff017',
            'label'         => 'Show link to all posts?',
            'name'          => 'news_show_all_link',
            'type'          => 'true_false',
            'instructions'  => 'Link to the tag archive view at the bottom of the list?',
            'default_value' => 1,
            'ui'            => 1,
            'wrapper'       => [
                'width' => '33',
                'class' => '',
                'id'    => '',
            ],
        ],
        [
            'key'          => 'field_61263568d2f46',
            'label'        => 'Featured Posts',
            'name'         => 'news_featured_posts',
            'type'         => 'post_object',
            'instructions' => 'Select posts to keep at the top of the news subpage.',
            'post_type'    => [
                0 => 'post',
            ],
            'allow_null'    => 1,
            'multiple'      => 1,
            'return_format' => 'object',
            'ui'            => 1,
        ],
        [
            'key'           => 'field_611fdfd220be5',
            'label'         => 'News Lead Content',
            'name'          => 'news_lead',
            'type'          => 'wysiwyg',
            'instructions'  => 'Content to appear at the top of the page, before the posts.',
            'default_value' => '',
            'tabs'          => 'all',
            'toolbar'       => 'full',
            'media_upload'  => 1,
            'delay'         => 1,
        ]
    ];
}
