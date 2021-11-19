<?php
/**
 * The template for displaying the Program sidebar with calls to action and contact info.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

?>
<section class="program-sidebar nvis-sidebar">
  <div class="nvis-sidebar__content">
    <?php nvis_prog_get_template_part('single-program/program-actions'); ?>
    <?php nvis_prog_get_template_part('single-program/application-deadlines'); ?>
    <?php nvis_prog_get_template_part('single-program/contact'); ?>

    <?php nvis_back_to_top_link(); ?>
  </div>
</section>