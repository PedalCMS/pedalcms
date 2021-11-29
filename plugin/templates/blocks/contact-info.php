<?php
/**
 * Displays a group of contact info for a Person.
 *
 * Primarily used to render the ContactInfo block but can be used anywhere.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'show_phone'  => true,
    'show_email'  => true,
    'show_office' => true,
    'show_labels' => false,
];

$args = wp_parse_args($args, $defaults);

if ($post):
?>
<div class="contact-info">
    <?php if ($args['show_phone'] && $post->office_phone) : ?>
    <div class="contact-info__field">
        <?php if ($args['show_labels']): ?>
        <span class="contact-info__label label">Phone<span class="separator">:</span></span>
        <?php endif; ?>

        <span class="contact-info__phone"><?php echo esc_html($post->office_phone); ?></span>
    </div>
    <?php endif; ?>

    <?php if ($args['show_email'] && $post->email_address) : ?>
    <div class="contact-info__field">
        <?php if ($args['show_labels']): ?>
        <span class="contact-info__label label">Email<span class="separator">:</span></span>
        <?php endif; ?>

        <a class="contact-info__email"
            href="mailto:<?php echo antispambot($post->email_address, true); ?>"><?php echo antispambot($post->email_address); ?></a>
    </div>
    <?php endif; ?>

    <?php if ($args['show_office'] && $post->office) : ?>
    <div class="contact-info__phone">
        <?php if ($args['show_labels']): ?>
        <span class="contact-info__label label">Office<span class="separator">:</span></span>
        <?php endif; ?>

        <?php echo esc_html($post->office); ?>
    </div>
    <?php endif; ?>

</div>
<?php endif;
