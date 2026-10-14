<?php
defined( 'ABSPATH' ) || exit;

$pedalcms_program_post = pedalcms_args_or_global( 'post', $args );

$pedalcms_defaults = [
	'show_subpage'        => pedalcms_show_subpage( 'curriculum' ),
	'subpage_content'     => pedalcms_get_field( 'pedalcms_apply_content', $pedalcms_program_post ),
	'curriculum_sections' => pedalcms_get_field( 'pedalcms_curriculum_sections', $pedalcms_program_post ),
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

if ( $pedalcms_args['show_subpage'] ) : ?>

<div <?php pedalcms_subpage_class(); ?>>
	<h2 class="program-subpage__title"><?php echo esc_html( pedalcms_subpage_title() ); ?></h2>

	<div class="program-subpage__content">
		<?php
		pedalcms_get_template_part( 'single-program/subpages/lead-content' );

		if ( is_array( $pedalcms_args['curriculum_sections'] ) ) :
			foreach ( $pedalcms_args['curriculum_sections'] as $pedalcms_section ) :
				pedalcms_get_template_part( 'single-program/curriculum-section', $pedalcms_section );
			endforeach;
		endif;
		?>
	</div>
</div>

	<?php
endif;
