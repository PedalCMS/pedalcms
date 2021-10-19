<header class="single-person-page-header single-person-page-header--classic page-header entry-header">
    <?php nvis_prog_get_template_part('common/breadcrumbs'); ?>

    <?php if (has_post_thumbnail()) : ?>
    <div class="person-featured-image">
        <?php the_post_thumbnail('medium'); ?>
    </div>
    <?php endif; ?>

    <h1 class="page-title entry-title">
        <?php the_title(); ?>
    </h1>
    <?php nvis_prog_get_template_part('single-person/person-meta'); ?>
    <?php nvis_prog_get_template_part('blocks/contact-info', ['post' => get_post(), 'show_labels' => true]); ?>

</header><!-- .page-header -->