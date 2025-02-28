<?php
/**
 * The template for displaying the document footer.
 *
 * A thin wrapper around get_footer().
 *
 * @package PedalCMS
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

/**
 * Fires just before the footer is loaded after the main content.
 *
 * @since 0.1
 */
do_action('pdl/after_main_content');

get_footer();
