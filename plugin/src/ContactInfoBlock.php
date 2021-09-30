<?php

namespace InvisibleUs\Programs;

/**
 * Contact Info custom block.
 * 
 * Used with Person post types.
 * 
 * @version 0.1.0
 * @package nvis-programs
 * @since 0.1.0
 */
class ContactInfoBlock extends CustomBlock {
    public static string $block_name = 'contact-info';

    public static array $editor_dependencies = [
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
            'blocks/contact-info',
            compact('post')
        );

        return ob_get_clean();
    }
}
