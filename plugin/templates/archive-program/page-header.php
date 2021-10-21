<?php
/**
 * Template for displaying the Program archive page header.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;
?>
<section class="programs-archive-page-header page-header">
  <?php nvis_prog_get_template_part('common/breadcrumbs'); ?>
  <h1 class="page-title">
    <?php
    if (is_post_type_archive('nvis_program')) {
        echo __('Browse Programs', 'wp-program-pages');
    } else {
        the_archive_title();
    }
    ?>
  </h1>
  <?php nvis_prog_get_template_part('archive-program/filters'); ?>
  <?php nvis_prog_get_template_part('archive-program/num-results'); ?>

</section><!-- .page-header -->