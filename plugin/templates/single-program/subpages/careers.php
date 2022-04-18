<?php
/**
 * The template for displaying the Careers Program Subpage.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'show_subpage'  => nvis_prog_show_subpage('careers'),
];

$args = nvis_parse_template_args($args, $defaults, $template);

if ($args['show_subpage']) :
  $careers = get_field('related_careers', $post);
?>

<div <?php nvis_subpage_class(); ?>>
  <h2 class="program-subpage__title"><?php echo esc_html(nvis_prog_subpage_title()); ?></h2>
  <?php nvis_prog_get_template_part('single-program/subpages/lead-content'); ?>

  <?php
    if (!empty($careers)) :
      if (function_exists('nvis_car_get_template_part')) :
        nvis_car_get_template_part(
            'archive-career/career-list',
            [
                'posts'                 => $careers,
                'title_tag'             => 'h3',
                'transpose_table'       => false,
                'show_related_programs' => false,
            ]
        );
      else:
        nvis_prog_get_template_part('common/posts-links', ['posts' => $careers]);
      endif;
    endif;
  ?>
</div>

<?php endif;
