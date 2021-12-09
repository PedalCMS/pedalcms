<?php
/**
 * The template for displaying the single Program page header.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;
?>
<header class="single-program-page-header page-header entry-header">

  <?php nvis_prog_get_template_part('common/page-header-backdrop'); ?>

  <div class="page-header__content">
    <?php nvis_prog_get_template_part('common/post-featured-image', ['image_size' => 'medium']); ?>

    <div class="page-header__title-group">
      <h1 class="page-title entry-title">
        <?php the_title(); ?>
      </h1>
      <div class="program-type taxonomy">
        <?php
        // TODO: Design a way to get a singular label here.
        the_terms(get_the_ID(), 'nvis_program_type');
        ?>
      </div>
    </div>
    <?php nvis_prog_get_template_part('single-program/program-meta'); ?>
    <?php nvis_prog_get_template_part('single-program/subnav'); ?>
  </div>
</header><!-- .page-header -->