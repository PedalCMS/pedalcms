<?php
/**
 * The template for displaying the Program sidebar with calls to action and contact info.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

?>
<section class="program-sidebar pdl-sidebar">
  <div class="pdl-sidebar__content pdl-sticky">
    <?php pdl_get_template_part('single-program/program-actions'); ?>
    <?php pdl_get_template_part('single-program/application-deadlines'); ?>
    <?php pdl_get_template_part('single-program/contact'); ?>

    <?php pdl_back_to_top_link(); ?>
  </div>
</section>
