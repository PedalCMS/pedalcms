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

$contact_post = pdl_args_or_global( 'post', $args );

$defaults = [
	'office_phone'  => $contact_post->office_phone,
	'email_address' => $contact_post->email_address,
	'office'        => $contact_post->office,
	'show_phone'    => true,
	'show_email'    => true,
	'show_office'   => true,
	'show_labels'   => false,
	'label_phone'   => pdl_get_label( 'phone' ),
	'label_email'   => pdl_get_label( 'email' ),
	'label_office'  => pdl_get_label( 'office' ),
];

$args = pdl_parse_template_args( $args, $defaults, $template );

if ( $contact_post ) :
	?>
<div class="contact-info">
	<?php if ( $args['show_phone'] && $args['office_phone'] ) : ?>
	<div class="contact-info__field">
		<?php if ( $args['show_labels'] ) : ?>
		<span class="contact-info__label label"><?php echo esc_html( $args['label_phone'] ); ?><span
				class="separator">:</span></span>
		<?php endif; ?>

		<span class="contact-info__phone"><?php echo esc_html( $args['office_phone'] ); ?></span>
	</div>
	<?php endif; ?>

	<?php if ( $args['show_email'] && $args['email_address'] ) : ?>
	<div class="contact-info__field">
		<?php if ( $args['show_labels'] ) : ?>
		<span class="contact-info__label label"><?php echo esc_html( $args['label_email'] ); ?><span
				class="separator">:</span></span>
		<?php endif; ?>

		<a class="contact-info__email"
			href="mailto:<?php echo esc_attr( antispambot( $args['email_address'], true ) ); ?>"><?php echo esc_html( antispambot( $args['email_address'] ) ); ?></a>
	</div>
	<?php endif; ?>

	<?php if ( $args['show_office'] && $args['office'] ) : ?>
	<div class="contact-info__phone">
		<?php if ( $args['show_labels'] ) : ?>
		<span class="contact-info__label label"><?php echo esc_html( $args['label_office'] ); ?><span
				class="separator">:</span></span>
		<?php endif; ?>

		<?php echo esc_html( $args['office'] ); ?>
	</div>
	<?php endif; ?>

</div>
	<?php
endif;
