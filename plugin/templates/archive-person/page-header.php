<?php
/**
 * Template for displaying the Person archive page header.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

?>
<section class="person-archive-page-header page-header">
  <?php nvis_prog_get_template_part('common/breadcrumbs'); ?>
  <h1 class="page-title">Faculty &amp; Staff Directory</h1>
  <?php nvis_prog_get_template_part('archive-person/filters'); ?>
  <?php nvis_prog_get_template_part('archive-person/num-results');?>
</section><!-- .page-header -->