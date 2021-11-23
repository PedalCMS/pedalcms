<?php
/**
 * The template for displaying the single Person page header when using the Classic Editor.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

?>
<header class="single-person-page-header single-person-page-header--classic page-header entry-header">
    <?php nvis_prog_get_template_part('common/page-header-backdrop', ['attachment_id' => 107892]); ?>
    <div class="page-header__content">
        <?php nvis_prog_get_template_part('common/post-featured-image', ['image_align' => 'left']); ?>

        <h1 class="page-title entry-title">
            <?php the_title(); ?>
        </h1>

        <?php nvis_prog_get_template_part('single-person/person-meta'); ?>
        <?php nvis_prog_get_template_part('blocks/contact-info', ['post' => get_post(), 'show_labels' => true]); ?>
    </div>
</header><!-- .page-header -->