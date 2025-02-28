<?php
/**
 * Template for displaying the Program archive page header.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'archive_title'    => pdl_get_archive_title(),
    'show_description' => true,
    'show_image'       => true,
    'image_align'      => 'right',
];

$args = pdl_parse_template_args($args, $defaults, $template);

?>
<section
  class="<?php echo get_post_type(); ?>-archive-page-header page-header">
  <?php pdl_get_template_part('common/page-header-backdrop', ['context' => $template, 'fallback_to_post' => false]); ?>
  <div class="page-header__content">
    <?php 
    if ($args['show_image']) :
      if (is_tax() && !pdl_is_filtered_results(pdl_get_post_types())) :
        pdl_get_template_part('common/term-featured-image', $args);
      else:
        pdl_get_template_part('common/post-type-featured-image', $args);
      endif;
    endif;
    ?>
    <h1 class="page-title">
      <?php echo $args['archive_title']; ?>
    </h1>
    <?php if ($args['show_description'] || $args['show_image']) : ?>
    <div class="archive-summary">
      <?php
      if ($args['show_description']) :
        the_archive_description('<div class="archive-description">', '</div>');
      endif;
      ?>
    </div>
    <?php endif; ?>
  </div>
</section><!-- .page-header -->