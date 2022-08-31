<?php

/**
 * Plugin Name: Invisible Us: Program Marketing Essentials
 * Plugin URI: https://invisible.us
 * Description: A student recruitment powerhouse that includes: program listings, course catalog, faculty & staff directory, and more.
 * Requires PHP: 7.4
 * Requires at least: 5.6
 * Version: 0.1
 * Author: Invisible Us
 * Author URI: https://invisible.us
 * Text Domain: nvis-program-pages
 *
 * @package NVISPrograms
 */

namespace InvisibleUs\Programs;

defined('ABSPATH') || exit;

$includes = [
    '/src/_autoload.php',
    '/src/acf.php',
    '/src/assets.php',
    '/src/hooks.php',
    '/src/shortcodes.php',
    '/src/breadcrumbs.php',
];

foreach ($includes as $subpath) {
    require __DIR__ . $subpath;
}

add_action('after_setup_theme', function () {
    require __DIR__ . '/src/template-tags.php';
    require __DIR__ . '/src/template-tags-shared.php';
});

$plugin = new Plugin();

register_activation_hook(__FILE__, [__NAMESPACE__ . '\Plugin', 'install']);
