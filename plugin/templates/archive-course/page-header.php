<?php
/**
 * Template for displaying the Course archive page header.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;
?>
<section class="person-archive-page-header page-header">
    <?php nvis_prog_get_template_part('common/breadcrumbs'); ?>
    <h1 class="page-title">Course Catalog</h1>
    <?php nvis_prog_get_template_part('archive-course/filters'); ?>
    <?php nvis_prog_get_template_part('archive-course/num-results');?>
</section><!-- .page-header -->