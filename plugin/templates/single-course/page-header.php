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
    <h1 class="page-title entry-title">
        <?php echo nvis_prog_get_full_course_title(); ?>
    </h1>
    <?php nvis_prog_get_template_part('single-course/course-meta'); ?>
</header><!-- .page-header -->