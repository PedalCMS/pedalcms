<header class="single-program-page-header page-header entry-header">
  <?php nvis_prog_get_template_part('common/breadcrumbs'); ?>
  <?php if (has_post_thumbnail()) : ?>
  <div class="program-featured-image">
    <?php the_post_thumbnail('medium'); ?>
  </div>
  <?php endif; ?>
  <h1 class="page-title entry-title">
    <?php the_title(); ?>
  </h1>
  <div class="program-level">
    <?php
    // TODO: Design a way to get a singular label here.
    the_terms(get_the_ID(), 'nvis_program_type');
    ?>
  </div>
  <?php nvis_prog_get_template_part('single-program/program-meta'); ?>
  <?php nvis_prog_get_template_part('single-program/subnav'); ?>
</header><!-- .page-header -->