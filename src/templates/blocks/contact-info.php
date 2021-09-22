<?php
    $post = $data['post'];
    $show_office = $data['show_office'] ?? false;
?>
<div class="contact-info">
    <?php if ($post->office_phone) : ?>
    <div class="contact-info__phone">
        <?php echo esc_html($post->office_phone); ?>
    </div>
    <?php endif; ?>

    <?php if ($post->email_address) : ?>
    <div class="contact-info__email">
        <a
            href="mailto:<?php echo antispambot($post->email_address, true); ?>"><?php echo antispambot($post->email_address); ?></a>
    </div>
    <?php endif; ?>

    <?php if ($post->office) : ?>
    <div class="contact-info__phone">
        <?php echo esc_html($post->office); ?>
    </div>
    <?php endif; ?>
</div>