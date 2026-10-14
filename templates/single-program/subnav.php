<?php
/**
 * The template for displaying the Program Subpage navigation.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'h_level'              => 2,
	'label_about_program'  => pedalcms_get_label( 'about_program' ),
	'label_program_subnav' => pedalcms_get_label( 'program_subnav' ),
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

$pedalcms_h_tag = pedalcms_get_heading_tag( $pedalcms_args['h_level'] );

if ( pedalcms_show_subpages() ) :
	$pedalcms_subpages = pedalcms_get_subpages(); ?>

<nav class="program-subnav" aria-label="<?php echo esc_attr( $pedalcms_args['label_program_subnav'] ); ?>">
	<?php
	printf(
		'<%s class="program-subnav__heading">%s</%s>',
		esc_html( $pedalcms_h_tag ),
		esc_html( $pedalcms_args['label_about_program'] ),
		esc_html( $pedalcms_h_tag )
	);
	?>
	<ul class="program-subnav__menu menu">
	<?php
	foreach ( $pedalcms_subpages as $pedalcms_subpage ) :
		if ( pedalcms_show_subpage( $pedalcms_subpage ) ) :
			?>
	<li
		class="<?php echo pedalcms_is_active_subpage( $pedalcms_subpage->slug ) ? 'active-subpage' : ''; ?>">
		<span>
		<a href="<?php pedalcms_subpage_link( $pedalcms_subpage->slug ); ?>" aria-label="<?php echo esc_attr( $pedalcms_subpage->aria_label ); ?>">
			<?php echo esc_html( $pedalcms_subpage->tab_label ); ?>
		</a>
		</span>
	</li>
			<?php
	endif;
endforeach;
	?>
	</ul>
</nav>

	<?php
endif;
