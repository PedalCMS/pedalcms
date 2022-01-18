<?php
/**
 * The template for displaying the Cost Program Subpage.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$label_est_cost = get_field('estimated_cost_label', $post);

if (empty($label_est_cost)) {
    $label_est_cost = nvis_prog_get_label('estimated_cost');
}

$defaults = [
    'show_subpage'         => nvis_prog_show_subpage('cost'),
    'subpage_title'        => nvis_prog_get_label('cost'),
    'subpage_content'      => get_field('cost_content', $post),
    'estimated_cost'       => get_field('estimated_cost', $post),
    'label_estimated_cost' => $label_est_cost
];

$args = wp_parse_args($args, $defaults);

if ($args['show_subpage']) : ?>

<div <?php nvis_subpage_class(); ?>>
  <h2 class="program-subpage__title"><?php echo esc_html($args['subpage_title']); ?>
  </h2>

  <div class="program-subpage__content">

    <?php if ($args['estimated_cost']) : ?>
    <div class="program-estimated-cost">
      <h3 class="program-estimated-cost__label"><?php echo esc_html($args['label_estimated_cost']); ?>
      </h3>
      <p class="program-estimated-cost__value"><?php echo esc_html($args['estimated_cost']); ?>
      </p>
    </div>
    <?php endif; ?>

    <div class="program-cost-content">
      <?php echo $args['subpage_content']; ?>
    </div>

  </div>
</div>

<?php endif;
