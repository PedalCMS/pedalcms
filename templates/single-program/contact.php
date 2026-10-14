<?php
/**
 * The template for displaying the Program contact section.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'action'                => 'contact',
	'label_program_contact' => pedalcms_get_label( 'program_contact' ),
	'label_contact_action'  => pedalcms_get_label( 'contact_action' ),
	'contacts'              => post_type_exists( 'pedalcms_person' ) ? pedalcms_get_field( 'pedalcms_related_contacts' ) : [],
];

$pedalcms_args       = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );
$pedalcms_action_url = pedalcms_get_action_link( $pedalcms_args['action'] );

if ( is_array( $pedalcms_args['contacts'] ) && ! empty( $pedalcms_args['contacts'] ) ) :
	?>
<div class="program-contacts">
	<h2 class="program-contacts__title program-sidebar__title">
	<?php echo esc_html( $pedalcms_args['label_program_contact'] ); ?>
	</h2>
	<?php
	foreach ( $pedalcms_args['contacts'] as $pedalcms_contact_post ) :
		pedalcms_get_template_part( 'single-program/contact-item', [ 'post' => $pedalcms_contact_post ] );
	endforeach;
	?>
</div>
<?php endif; ?>

<?php if ( $pedalcms_action_url ) : ?>
<a class="<?php echo esc_attr( $pedalcms_args['action'] ); ?>-button button button-secondary"
	href="<?php echo esc_url( $pedalcms_action_url ); ?>"><?php echo esc_html( $pedalcms_args['label_contact_action'] ); ?></a>
	<?php
endif;
