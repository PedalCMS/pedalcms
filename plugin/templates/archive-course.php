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
    <?php nvis_prog_get_template_part('archive-course/page-header'); ?>
    <?php nvis_prog_get_template_part('archive-course/course-list', ['courses' => $posts]); ?>
    <?php nvis_prog_get_template_part('common/pagination'); ?>
</div>
<?php nvis_prog_get_template_part('common/footer');
