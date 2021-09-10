<?php $person = $data['person'] ?? null; ?>

<?php if ($person) :?>
<div class="program-contact">
    <?php echo get_the_post_thumbnail($person, 'thumbnail', ['class' => 'program-contact__picture']); ?>
    <div class="program-contact__name"><?php echo get_the_title($person); ?>
    </div>

    <?php if (get_field('job_title', $person)) : ?>
    <div class="program-contact__title"><?php the_field('job_title', $person); ?>
    </div>
    <?php endif; ?>

    <?php if (get_field('office_phone', $person)) : ?>
    <div class="program-contact__phone">
        <?php the_field('office_phone', $person); ?>
    </div>
    <?php endif; ?>

    <?php if (get_field('email_address', $person)) : ?>
    <div class="program-contact__email">
        <a
            href="mailto:<?php echo antispambot(get_field('email_address', $person), true); ?>"><?php echo antispambot(get_field('email_address', $person)); ?></a>
    </div>
    <?php endif; ?>

</div>
<?php endif;
