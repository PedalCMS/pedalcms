<?php

namespace InvisibleUs\Programs;

class JobTitleBlock extends CustomBlock {
    public static $block_name = 'job-title';

    public static $editor_dependencies = [
        'wp-blocks',
        'wp-element',
        'wp-components',
        'wp-data',
        'wp-core-data',
        'wp-block-editor'
    ];

    public static function render(array $block_attributes, string $content): string {
        $post = get_post();

        ob_start();
        nvis_prog_get_template_part(
            'blocks/job-title',
            ['job_title' => $post->job_title]
        );

        return ob_get_clean();
    }
}
