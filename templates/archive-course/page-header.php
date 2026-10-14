<?php
/**
 * Template for displaying the Course archive page header.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_args            = $args;
$pedalcms_args['context'] = $template;

pedalcms_get_template_part( 'common/post-type-archive-page-header', $pedalcms_args );
