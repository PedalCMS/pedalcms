<?php
/**
 * The template for displaying the single Course page header.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

?>
<header class="single-course-page-header page-header entry-header">
    <?php nvis_prog_get_template_part('common/breadcrumbs'); ?>
    <h1 class="page-title entry-title">
        <?php the_title(); ?>
    </h1>
</header><!-- .page-header -->