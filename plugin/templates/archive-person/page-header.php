<?php
/**
 * Template for displaying the Person archive page header.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$args['context'] = $template;

pdl_get_template_part('common/post-type-archive-page-header', $args);
