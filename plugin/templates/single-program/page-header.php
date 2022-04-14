<?php
/**
 * The template for displaying the single Program page header.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'link_terms' => true,
];

$args = nvis_parse_template_args($args, $defaults, $template);
$args['context'] = $template;

?>
<header class="single-program-page-header page-header entry-header">

  <?php nvis_prog_get_template_part('common/page-header-backdrop'); ?>

  <div class="page-header__content">
    <?php nvis_prog_get_template_part('common/post-featured-image', $args); ?>

    <div class="page-header__title-group">
      <h1 class="page-title entry-title">
        <?php the_title(); ?>
      </h1>
      <?php if (taxonomy_exists('nvis_program_type')) :?>
      <div class="program-type taxonomy">
        <?php echo nvis_get_the_term_list(get_the_ID(), 'nvis_program_type', '', ', ', '', $args['link_terms']);?>
      </div>
      <?php endif; ?>
    </div>
    <?php nvis_prog_get_template_part('single-program/program-meta'); ?>
    <?php nvis_prog_get_template_part('single-program/subnav'); ?>
  </div>
</header><!-- .page-header -->
