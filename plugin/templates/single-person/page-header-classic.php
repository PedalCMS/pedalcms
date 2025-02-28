<?php
/**
 * The template for displaying the single Person page header when using the Classic Editor.
 *
 * @package PedalCMS
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

?>
<header class="single-person-page-header single-person-page-header--classic page-header entry-header">
    <?php pdl_get_template_part('common/page-header-backdrop', ['fallback_to_post' => false]); ?>
    <div class="page-header__content">
        <?php pdl_get_template_part('common/post-featured-image', ['image_align' => 'left']); ?>

        <h1 class="page-title entry-title">
            <?php the_title(); ?>
        </h1>

        <?php pdl_get_template_part('single-person/person-meta'); ?>
        <?php pdl_get_template_part('blocks/contact-info', ['context' => $template, 'post' => get_post(), 'show_labels' => true]); ?>
    </div>
</header><!-- .page-header -->