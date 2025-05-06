<?php
/**
 * The template for displaying the single Program page header.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'link_terms' => true,
];

$args = pdl_parse_template_args($args, $defaults, $template);
$args['context'] = $template;

?>
<header class="single-program-page-header page-header entry-header">

  <?php pdl_get_template_part('common/page-header-backdrop'); ?>

  <div class="page-header__content">
    <?php pdl_get_template_part('common/post-featured-image', $args); ?>

    <div class="page-header__title-group">
      <h1 class="page-title entry-title">
        <?php the_title(); ?>
      </h1>
      <?php if (taxonomy_exists('pdl_program_type')) :?>
      <div class="program-type taxonomy">
        <?php echo pdl_get_the_term_list(get_the_ID(), 'pdl_program_type', '', ', ', '', $args['link_terms']);?>
      </div>
      <?php endif; ?>
    </div>
    <?php pdl_get_template_part('single-program/program-meta'); ?>
    <?php pdl_get_template_part('single-program/subnav'); ?>
  </div>
</header><!-- .page-header -->
