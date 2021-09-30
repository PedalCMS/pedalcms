<?php

namespace InvisibleUs\Programs;

abstract class CustomBlock {
    public static string $namespace = 'nvis';
    public static string $block_name = 'custom-block';

    public static array $editor_dependencies = [];

    public static array $assets = [
        'editor.js' => [
            'type'         => 'script',
            'editor_only'  => true,
            'dependencies' => []
        ],
        'editor.css' => [
            'type'         => 'style',
            'editor_only'  => true,
            'dependencies' => []
        ],
        'script.js' => [
            'type'         => 'script',
            'editor_only'  => false,
            'dependencies' => []
        ],
        'style.css' => [
            'type'         => 'style',
            'editor_only'  => false,
            'dependencies' => []
        ]
    ];

    public function __construct() {
        $block_dir = __DIR__ . '/blocks/' . static::$block_name;
        // error_log($block_dir);

        register_block_type(
            $block_dir,
            ['render_callback' => [static::class, 'render'] ]
        );

        add_action('enqueue_block_assets', [static::class, 'load_assets']);
    }

    public static function load_assets(): void {
        $block_path = sprintf('%s/blocks/%s/', __DIR__, static::$block_name);
        $block_url = trailingslashit(Plugin::$url . '/src/blocks/' . static::$block_name);
        $asset_handle = sprintf(
            '%s-block-%s-',
            static::$namespace,
            static::$block_name
        );

        $register = 'index.js';

        wp_enqueue_script(
            $asset_handle . 'register',
            $block_url . $register,
            static::$editor_dependencies,
            filemtime($block_path . $register),
            true
        );


        foreach (static::$assets as $asset => $props) {
            if (!is_admin() && $props['editor_only']) {
                continue;
            }

            if (!file_exists($block_path . $asset)) {
                continue;
            }

            // TODO: fix asset_handles.
            if ($props['type'] === 'style') {
                wp_enqueue_style(
                    $asset_handle,
                    $block_url . $asset,
                    $props['dependencies'],
                    filemtime($block_path . $asset)
                );
            } elseif ($props['type'] == 'script') {
                wp_enqueue_script(
                    $asset_handle,
                    $block_url . $asset,
                    $props['dependencies'],
                    filemtime($block_path . $asset),
                    true
                );
            }
        }
    }

    public static function render(array $block_attributes, string $content): string {
        return '';
    }
}
