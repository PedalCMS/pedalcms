<?php
/**
 * The template for displaying a Program contact person.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = $args['post'];

if ($post) :
?>
<div class="program-contact">
    <?php echo get_the_post_thumbnail($post, 'thumbnail', ['class' => 'program-contact__picture']); ?>
    <div class="program-contact__name"><?php echo get_the_title($post); ?>
    </div>
    <?php pdl_get_template_part('blocks/job-title', ['job_title' => $post->job_title]); ?>
    <?php pdl_get_template_part('blocks/contact-info', compact('post')); ?>
</div>
<?php endif;
