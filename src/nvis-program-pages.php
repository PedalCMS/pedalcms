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
 * @package nvis-program-pages
 */

namespace InvisibleUs\Programs;

define('NVIS_PROGRAMS_PLUGIN_NAME', basename(__DIR__));
define('NVIS_PROGRAMS_PATH', __DIR__);
define('NVIS_PROGRAMS_URL', plugins_url('', __FILE__));
define('NVIS_PROGRAMS_TEMPLATE_PATH', NVIS_PROGRAMS_PATH . '/templates/');

$includes = [
    '/src/_autoload.php',
    '/src/_init.php',
    '/src/acf.php',
    '/src/assets.php',
    '/src/ajax.php',
    '/src/template-tags.php',
    '/src/breadcrumbs.php',
];

foreach ($includes as $subpath) {
    require __DIR__ . $subpath;
}
