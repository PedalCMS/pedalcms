<?php
/**
 * The template for displaying the Cost Program Subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_program_post = pedalcms_args_or_global( 'post', $args );

$pedalcms_label_est_cost = pedalcms_get_field( 'pedalcms_estimated_cost_label', $pedalcms_program_post );

if ( empty( $pedalcms_label_est_cost ) ) {
	$pedalcms_label_est_cost = pedalcms_get_label( 'estimated_cost' );
}

$pedalcms_defaults = [
	'show_subpage'         => pedalcms_show_subpage( 'cost' ),
	'subpage_content'      => pedalcms_get_field( 'pedalcms_cost_content', $pedalcms_program_post ),
	'estimated_cost'       => pedalcms_get_field( 'pedalcms_estimated_cost', $pedalcms_program_post ),
	'label_estimated_cost' => $pedalcms_label_est_cost,
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

if ( $pedalcms_args['show_subpage'] ) : ?>

<div <?php pedalcms_subpage_class(); ?>>
	<h2 class="program-subpage__title"><?php echo esc_html( pedalcms_subpage_title() ); ?></h2>

	<div class="program-subpage__content">

	<?php if ( $pedalcms_args['estimated_cost'] ) : ?>
	<div class="program-estimated-cost">
		<h3 class="program-estimated-cost__label"><?php echo esc_html( $pedalcms_args['label_estimated_cost'] ); ?>
		</h3>
		<p class="program-estimated-cost__value"><?php echo esc_html( $pedalcms_args['estimated_cost'] ); ?>
		</p>
	</div>
	<?php endif; ?>

	<div class="program-cost-content">
		<?php echo wp_kses_post( $pedalcms_args['subpage_content'] ); ?>
	</div>

	</div>
</div>

	<?php
endif;
