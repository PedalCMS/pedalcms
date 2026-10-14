<?php
/**
 * Displays a group of contact info for a Person.
 *
 * Primarily used to render the ContactInfo block but can be used anywhere.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_contact_post = pedalcms_args_or_global( 'post', $args );
$pedalcms_contact_post = get_post( $pedalcms_contact_post );

if ( ! $pedalcms_contact_post instanceof \WP_Post ) :
	return;
endif;

$pedalcms_defaults = [
	'office_phone'  => $pedalcms_contact_post->pedalcms_office_phone,
	'email_address' => $pedalcms_contact_post->pedalcms_email_address,
	'office'        => $pedalcms_contact_post->pedalcms_office,
	'show_phone'    => true,
	'show_email'    => true,
	'show_office'   => true,
	'show_labels'   => false,
	'label_phone'   => pedalcms_get_label( 'phone' ),
	'label_email'   => pedalcms_get_label( 'email' ),
	'label_office'  => pedalcms_get_label( 'office' ),
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );
?>
<div class="contact-info">
	<?php if ( $pedalcms_args['show_phone'] && $pedalcms_args['office_phone'] ) : ?>
	<div class="contact-info__field">
		<?php if ( $pedalcms_args['show_labels'] ) : ?>
		<span class="contact-info__label label"><?php echo esc_html( $pedalcms_args['label_phone'] ); ?><span
				class="separator">:</span></span>
		<?php endif; ?>

		<span class="contact-info__phone"><?php echo esc_html( $pedalcms_args['office_phone'] ); ?></span>
	</div>
	<?php endif; ?>

	<?php if ( $pedalcms_args['show_email'] && $pedalcms_args['email_address'] ) : ?>
	<div class="contact-info__field">
		<?php if ( $pedalcms_args['show_labels'] ) : ?>
		<span class="contact-info__label label"><?php echo esc_html( $pedalcms_args['label_email'] ); ?><span
				class="separator">:</span></span>
		<?php endif; ?>

		<a class="contact-info__email"
			href="mailto:<?php echo esc_attr( antispambot( $pedalcms_args['email_address'], true ) ); ?>"><?php echo esc_html( antispambot( $pedalcms_args['email_address'] ) ); ?></a>
	</div>
	<?php endif; ?>

	<?php if ( $pedalcms_args['show_office'] && $pedalcms_args['office'] ) : ?>
	<div class="contact-info__phone">
		<?php if ( $pedalcms_args['show_labels'] ) : ?>
		<span class="contact-info__label label"><?php echo esc_html( $pedalcms_args['label_office'] ); ?><span
				class="separator">:</span></span>
		<?php endif; ?>

		<?php echo esc_html( $pedalcms_args['office'] ); ?>
	</div>
	<?php endif; ?>

</div>
