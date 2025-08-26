<?php
defined( 'ABSPATH' ) || exit;

$program_post = pdl_args_or_global( 'post', $args );

$defaults = [
	'show_subpage'        => pdl_show_subpage( 'curriculum' ),
	'subpage_content'     => get_field( 'apply_content', $program_post ),
	'curriculum_sections' => get_field( 'curriculum_sections', $program_post ),
];

$args = pdl_parse_template_args( $args, $defaults, $template );

if ( $args['show_subpage'] ) : ?>

<div <?php pdl_subpage_class(); ?>>
	<h2 class="program-subpage__title"><?php echo esc_html( pdl_subpage_title() ); ?></h2>

	<div class="program-subpage__content">
		<?php
		pdl_get_template_part( 'single-program/subpages/lead-content' );

		if ( is_array( $args['curriculum_sections'] ) ) :
			foreach ( $args['curriculum_sections'] as $section ) :
				pdl_get_template_part( 'single-program/curriculum-section', $section );
			endforeach;
		endif;
		?>
	</div>
</div>

	<?php
endif;
