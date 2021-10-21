<?php
/**
 * The template for displaying the News Program Subpage.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

if (nvis_prog_show_subpage('news')) : ?>

<div class="program-news-subpage program-subpage">
    <h2 class="section-head">News</h2>

    <?php nvis_prog_get_template_part('single-program/subpages/lead-content'); ?>
    <?php nvis_prog_get_template_part('single-program/related-posts'); ?>
</div>

<?php endif;
