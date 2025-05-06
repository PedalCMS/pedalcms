<?php
/**
 * The template for displaying program archives.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */
defined('ABSPATH') || exit;

global $posts;

pdl_get_template_part('common/header'); ?>
<div class="programs-archive-main">
    <?php
        pdl_get_template_part('common/breadcrumbs');
        pdl_get_template_part('archive-program/page-header');
        pdl_get_template_part('archive-program/filters');
        pdl_get_template_part('archive-program/num-results');
        pdl_get_template_part('archive-program/program-list', ['programs' => $posts]);
        pdl_get_template_part('common/pagination');
    ?>
</div>
<?php pdl_get_template_part('common/footer');
