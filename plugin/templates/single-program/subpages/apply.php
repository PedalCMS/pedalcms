<?php
/**
 * The template for displaying the How to Apply Program Subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = pdl_args_or_global('post', $args);

$defaults = [
    'show_subpage'    => pdl_show_subpage('apply'),
    'subpage_content' => get_field('apply_content', $post)
];

$args = pdl_parse_template_args($args, $defaults, $template);

if ($args['show_subpage']) : ?>

<div <?php pdl_subpage_class(); ?>>
  <h2 class="program-subpage__title"><?php echo esc_html(pdl_subpage_title()); ?></h2>
  <div class="program-subpage__content">
    <?php echo $args['subpage_content']; ?>
  </div>
</div>

<?php endif;
