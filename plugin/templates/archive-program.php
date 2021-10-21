<?php
/**
 * The template for displaying program archives.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */
defined('ABSPATH') || exit;

global $posts;

nvis_prog_get_template_part('common/header'); ?>
<div class="programs-archive-main">
    <?php nvis_prog_get_template_part('archive-program/page-header'); ?>
    <?php nvis_prog_get_template_part('archive-program/program-list', ['programs' => $posts]); ?>
    <?php nvis_prog_get_template_part('common/pagination'); ?>
</div>
<?php nvis_prog_get_template_part('common/footer');
