<?php
    $post = $data['post'];

    if ($post) :
?>
<div class="program-contact">
    <?php echo get_the_post_thumbnail($post, 'thumbnail', ['class' => 'program-contact__picture']); ?>
    <div class="program-contact__name"><?php echo get_the_title($post); ?>
    </div>
    <?php nvis_prog_get_template_part('blocks/job-title', ['job_title' => $post->job_title]); ?>
    <?php nvis_prog_get_template_part('blocks/contact-info', compact('post')); ?>
</div>
<?php endif;
