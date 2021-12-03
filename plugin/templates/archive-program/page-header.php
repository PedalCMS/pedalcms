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
    'archive_title'    => post_type_archive_title('', false),
    'show_description' => true,
    'show_image'       => true,
];

$args = wp_parse_args($args, $defaults);

?>
<section class="programs-archive-page-header page-header">
  <?php nvis_prog_get_template_part('common/page-header-backdrop', ['context' => $template, 'fallback_to_post' => false]); ?>
  <div class="page-header__content">
    <h1 class="page-title">
      <?php echo $args['archive_title']; ?>
    </h1>
    <?php if ($args['show_description'] || $args['show_image']) : ?>
    <div class="archive-summary">
      <?php
      if ($args['show_description']) :
        the_archive_description('<div class="archive-description">', '</div>');
      endif;

      if ($args['show_image']) :
        // TODO: Load the image.
      endif;
      ?>
    </div>
    <?php endif; ?>
  </div>
</section><!-- .page-header -->