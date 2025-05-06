<?php
/**
 * The template for displaying the Program Subpage navigation.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'h_level'              => 2,
    'label_about_program'  => pdl_get_label('about_program'),
    'label_program_subnav' => pdl_get_label('program_subnav')
];

$args = pdl_parse_template_args($args, $defaults, $template);

$h_tag = pdl_get_heading_tag($args['h_level']);

if (pdl_show_subpages()) : $subpages = pdl_get_subpages(); ?>

<nav class="program-subnav" aria-label="<?php echo esc_attr( $args['label_program_subnav'] ); ?>">
  <?php
  printf(
    '<%s class="program-subnav__heading">%s</%s>',
    $h_tag,
    esc_html($args['label_about_program']),
    $h_tag
); ?>
  <ul class="program-subnav__menu menu">
    <?php
      foreach ($subpages as $subpage) :
        if (pdl_show_subpage($subpage)) :
    ?>
    <li
      class="<?php echo pdl_is_active_subpage($subpage->slug) ? 'active-subpage' : ''; ?>">
      <span>
        <a href="<?php pdl_subpage_link($subpage->slug); ?>" aria-label="<?php echo esc_attr($subpage->aria_label); ?>">
          <?php echo esc_html($subpage->tab_label); ?>
        </a>
      </span>
    </li>
    <?php endif; endforeach; ?>
  </ul>
</nav>

<?php endif;
