<?php

namespace InvisibleUs\Programs;

/**
 * Base class for common custom block tasks in WordPress.
 *
 * @version 0.1.0
 * @package NVISPrograms
 * @subpackage StandardLib
 * @since 0.1.0
 */
abstract class CustomBlock {
    /**
     * The namespace to prefix the block.
     *
     * Example: 'nvis/block-name'
     *
     * @var string
     */
    public static string $namespace = 'nvis';
    /**
     * The block's machine name.
     *
     * @var string
     */
    public static string $block_name = 'custom-block';

    /**
     * Dependencies of the registerBlockType script.
     *
     * A list of handles of registered scripts that are required by the
     * index.js script that registers the block.
     *
     * @var array Array of script handles.
     */
    public static array $editor_dependencies = [];

    /**
     * A list of other assets to enqueue.
     *
     * By default, this list includes both a script and a stylesheet for
     * everywhere and for only in the editor. To prevent checking if these
     * files exist, can be set to an empty array.
     *
     * @var array Associative array of assets indexed by filename.
     */
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

    /**
     * Constructor.
     */
    public function __construct() {
        $block_dir = __DIR__ . '/blocks/' . static::$block_name;
        // error_log($block_dir);

        register_block_type(
            $block_dir,
            ['render_callback' => [static::class, 'render'] ]
        );

        add_action('enqueue_block_assets', [static::class, 'load_assets']);
    }

    /**
     * Loads all block assets.
     *
     * Fired on enqueue_block_assets (both frontend and editor) and filters
     * out admin_only assets as necessary.
     *
     * @return void
     */
    public static function load_assets(): void {
        $block_path = sprintf('%s/blocks/%s/', __DIR__, static::$block_name);
        $block_url = trailingslashit(Plugin::$url . '/src/blocks/' . static::$block_name);

        $register = 'index.js';

        wp_enqueue_script(
            self::get_asset_handle('register', true),
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

            if ($props['type'] === 'style') {
                wp_enqueue_style(
                    self::get_asset_handle($asset, $props['editor_only']),
                    $block_url . $asset,
                    $props['dependencies'],
                    filemtime($block_path . $asset)
                );
            } elseif ($props['type'] == 'script') {
                wp_enqueue_script(
                    self::get_asset_handle($asset, $props['editor_only']),
                    $block_url . $asset,
                    $props['dependencies'],
                    filemtime($block_path . $asset),
                    true
                );
            }
        }
    }

    /**
     * Gets a unique handle for the block asset.
     *
     * @param string $name Name or filename of the asset.
     * @param boolean $editor_only Whether this asset only loads in the editor.
     * @return string Asset handle.
     */
    public static function get_asset_handle(string $name, bool $editor_only): string {
        $dot = stripos($name, '.');

        return sprintf(
            '%s%s-block-%s-%s',
            $editor_only ? 'admin-' : '',
            static::$namespace,
            static::$block_name,
            $dot ? substr($name, 0, $dot) : $name
        );
    }

    /**
     * Renders the block.
     *
     * @param array $block_attributes Array of block attributes and their values.
     * @param string $content Block content.
     * @return string The HTML output.
     */
    public static function render(array $block_attributes, string $content): string {
        return '';
    }
}
