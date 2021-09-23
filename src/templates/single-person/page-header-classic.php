<header class="single-person-page-header page-header entry-header">
    <?php nvis_prog_get_template_part('breadcrumbs'); ?>
    <?php if (has_post_thumbnail()) : ?>
    <div class="person-featured-image">
        <?php the_post_thumbnail('medium'); ?>
    </div>
    <?php endif; ?>
    <h1 class="page-title entry-title">
        <?php the_title(); ?>
    </h1>
    <?php nvis_prog_get_template_part('single-person-meta'); ?>
</header><!-- .page-header -->