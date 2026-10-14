<?php
/**
 * The template for displaying the How to Apply Program Subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_program_post = pedalcms_args_or_global( 'post', $args );

$pedalcms_defaults = [
	'show_subpage'    => pedalcms_show_subpage( 'apply' ),
	'subpage_content' => pedalcms_get_field( 'pedalcms_apply_content', $pedalcms_program_post ),
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

if ( $pedalcms_args['show_subpage'] ) : ?>

<div <?php pedalcms_subpage_class(); ?>>
	<h2 class="program-subpage__title"><?php echo esc_html( pedalcms_subpage_title() ); ?></h2>
	<div class="program-subpage__content">
	<?php echo wp_kses_post( $pedalcms_args['subpage_content'] ); ?>
	</div>
</div>

	<?php
endif;
