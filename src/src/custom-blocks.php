<?php

namespace InvisibleUs\Programs;

function block_enqueue() {
    wp_enqueue_script(
        'nvis-block-job-title',
        Plugin::$url . '/src/blocks/job-title/index.js',
        [ 'wp-blocks', 'wp-element', 'wp-components', 'wp-data', 'wp-core-data', 'wp-block-editor' ]
    );

    wp_enqueue_style(
        'nvis-block-job-title',
        Plugin::$url . '/src/blocks/job-title/editor.css',
    );
}
add_action('enqueue_block_editor_assets', __NAMESPACE__ . '\block_enqueue');



function render_block_job_title(array $block_attributes, string $content): string {
    $person = get_post();

    ob_start();
    nvis_prog_get_template_part(
        'blocks/job-title',
        ['job_title' => $person->job_title]
    );

    return ob_get_clean();
}
