<?php

defined('ABSPATH') || exit;

$post = $data['post'] ?? null;
$show_office = $data['show_office'] ?? true;
$show_labels = $data['show_labels'] ?? false;

if ($post):
?>
<div class="contact-info">
    <?php if ($post->office_phone) : ?>
    <div class="contact-info__field">
        <?php if ($show_labels): ?>
        <span class="contact-info__label label">Phone<span class="separator">:</span></span>
        <?php endif; ?>

        <span class="contact-info__phone"><?php echo esc_html($post->office_phone); ?></span>
    </div>
    <?php endif; ?>

    <?php if ($post->email_address) : ?>
    <div class="contact-info__field">
        <?php if ($show_labels): ?>
        <span class="contact-info__label label">Email<span class="separator">:</span></span>
        <?php endif; ?>

        <a class="contact-info__email"
            href="mailto:<?php echo antispambot($post->email_address, true); ?>"><?php echo antispambot($post->email_address); ?></a>
    </div>
    <?php endif; ?>

    <?php if ($post->office && $show_office) : ?>
    <div class="contact-info__phone">
        <?php if ($show_labels): ?>
        <span class="contact-info__label label">Office<span class="separator">:</span></span>
        <?php endif; ?>

        <?php echo esc_html($post->office); ?>
    </div>
    <?php endif; ?>
</div>
<?php endif;
