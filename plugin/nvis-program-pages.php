<?php

/**
 * Plugin Name: Pedal CMS
 * Plugin URI: https://verifiedstudios.com
 * Description: A student recruitment powerhouse that includes: program listings, course catalog, faculty & staff directory, and more.
 * Requires PHP: 7.4
 * Requires at least: 5.6
 * Version: 0.1
 * Author: pedalcms
 * Author URI: https://verifiedstudios.com
 * Text Domain: nvis-program-pages
 * License: GPL 2.0 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * 
 * ---
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses.
 * 
 * --- 
 *
 * @package NVISPrograms
 * 
 */

namespace InvisibleUs\Programs;

defined('ABSPATH') || exit;

$includes = [
    // '/src/freemius.php',
    '/src/_autoload.php',
    '/src/acf.php',
    '/src/ajax.php',
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
