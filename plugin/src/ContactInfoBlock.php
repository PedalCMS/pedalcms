<?php

namespace PedalCMS\Core;

/**
 * Contact Info custom block.
 *
 * Used with Person post types.
 *
 * @package PedalCMS
 * @since 0.1.0
 */
class ContactInfoBlock extends CustomBlock {
    /**
     * @inheritdoc
     */

    public static string $block_name = 'contact-info';
    /**
     * @inheritdoc
     */
    public static array $editor_dependencies = [
        'wp-blocks',
        'wp-element',
        'wp-components',
        'wp-data',
        'wp-core-data',
        'wp-block-editor'
    ];

    /**
     * @inheritdoc
     */
    public static function render(array $block_attributes, string $content): string {
        $post = get_post();

        ob_start();
        pdl_get_template_part(
            'blocks/contact-info',
            compact('post')
        );

        return ob_get_clean();
    }
}
