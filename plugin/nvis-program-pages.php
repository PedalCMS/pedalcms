<?php

/**
 * Plugin Name: Program Pages
 * Plugin URI: https://invisible.us
 * Description: Creates program listing capabilities.
 * Requires PHP: 7.4
 * Requires at least: 5.6
 * Version: 0.1
 * Author: Invisible Us
 * Author URI: https://invisible.us
 * Text Domain: nvis-program-pages
 *
 * @package nvis-programs
 */

namespace InvisibleUs\Programs;

$includes = [
    '/src/_autoload.php',
    '/src/acf.php',
    '/src/assets.php',
    '/src/hooks.php',
    '/src/template-tags.php',
    '/src/breadcrumbs.php',
];

foreach ($includes as $subpath) {
    require __DIR__ . $subpath;
}

$plugin = new Plugin();
