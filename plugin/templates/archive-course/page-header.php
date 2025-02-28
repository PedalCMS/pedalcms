<?php
/**
 * Template for displaying the Course archive page header.
 *
 * @package PedalCMS
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$args['context'] = $template;

pdl_get_template_part('common/post-type-archive-page-header', $args);
