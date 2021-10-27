<?php
/**
 * The template for displaying the Cost Program Subpage.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

if (nvis_prog_show_subpage('cost')) : ?>

<div class="program-cost-subpage program-subpage">
  <h2 class="section-head">Cost</h2>

  <?php
  $cost = get_field('estimated_cost');

  if ($cost) :
    $label = get_field('estimated_cost_label');
    $label = $label ? $label : 'Estimated Cost';
  ?>
  <div class="program-estimated-cost">
    <h3 class="program-estimated-cost__label"><?php echo esc_html($label); ?>
    </h3>
    <p class="program-estimated-cost__value"><?php echo esc_html($cost); ?>
    </p>
  </div>
  <?php endif; ?>

  <div class="program-cost-content">
    <?php the_field('cost_content'); ?>
  </div>
</div>

<?php endif;
