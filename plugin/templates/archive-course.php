<?php
/**
 * The template for displaying course archives.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */
defined('ABSPATH') || exit;

global $posts;

pdl_get_template_part('common/header'); ?>
<div class="course-archive-main">
    <?php
    pdl_get_template_part('common/breadcrumbs');
    pdl_get_template_part('archive-course/page-header');
    pdl_get_template_part('archive-course/filters');
    pdl_get_template_part('archive-course/num-results');
    pdl_get_template_part('archive-course/course-list', ['courses' => $posts]);
    pdl_get_template_part('common/pagination');
    ?>
</div>
<?php pdl_get_template_part('common/footer');
