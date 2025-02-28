<?php
/**
 * The template for displaying the Program Overview Subpage.
 *
 * @package PedalCMS
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

?>
<div <?php pdl_subpage_class(); ?>>
  <div class="program-overview-content">
    <?php the_field('overview_content'); ?>
  </div>
</div>