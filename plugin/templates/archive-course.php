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

nvis_prog_get_template_part('common/header'); ?>
<div class="course-archive-main">
    <?php
    nvis_prog_get_template_part('common/breadcrumbs');
    nvis_prog_get_template_part('archive-course/page-header');
    nvis_prog_get_template_part('archive-course/filters');
    nvis_prog_get_template_part('archive-course/num-results');
    nvis_prog_get_template_part('archive-course/course-list', ['courses' => $posts]);
    nvis_prog_get_template_part('common/pagination');
    ?>
</div>
<?php nvis_prog_get_template_part('common/footer');
