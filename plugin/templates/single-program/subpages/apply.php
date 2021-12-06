<?php
/**
 * The template for displaying the How to Apply Program Subpage.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'show_subpage'    => nvis_prog_show_subpage('apply'),
    'subpage_title'   => 'How to Apply',
    'subpage_content' => get_field('apply_content', $post)
];

$args = wp_parse_args($args, $defaults);

if ($args['show_subpage']) : ?>

<div <?php nvis_subpage_class(); ?>>
  <h2 class="program-subpage__title"><?php echo esc_html($args['subpage_title']); ?>
  </h2>
  <div class="program-subpage__content">
    <?php echo $args['subpage_content']; ?>
  </div>
</div>

<?php endif;
