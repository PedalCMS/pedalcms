<section class="programs-archive-page-header page-header">
  <?php nvis_prog_get_template_part('breadcrumbs'); ?>
  <h1 class="page-title">
    <?php
    if (is_post_type_archive('nvis_program')) {
      echo __('Browse Programs', 'wp-program-pages');
    } else {
      the_archive_title();
    }
    ?>
  </h1>
  <?php nvis_prog_get_template_part('program-filters'); ?>
  <?php nvis_prog_get_template_part('program-list-count'); ?>
</section><!-- .page-header -->
