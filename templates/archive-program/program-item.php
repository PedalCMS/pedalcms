<?php
/**
 * Displays a single Program item, for use in an archive or other Program list.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'program_post'         => null,
	'show_image'           => true,
	'show_program_type'    => true,
	'show_program_meta'    => true,
	'show_program_actions' => true,
	'link_terms'           => false,
	'wrapper_class'        => '',
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

if ( $pedalcms_args['program_post'] ) : ?>
<article <?php post_class( $pedalcms_args['wrapper_class'], $pedalcms_args['program_post'] ); ?>>

	<?php
	if ( $pedalcms_args['show_image'] ) :
		pedalcms_get_template_part(
			'common/post-featured-image',
			[
				'post'        => $pedalcms_args['program_post'],
				'image_size'  => 'medium',
				'image_align' => 'left',
				'link_image'  => true,
				'context'     => $template,
			]
		);
	endif;
	?>

	<div class="program-info item-info">
		<header>
			<h2 class="program-title entry-title"><a
					href="<?php echo esc_url( get_the_permalink( $pedalcms_args['program_post'] ) ); ?>"><?php echo esc_html( get_the_title( $pedalcms_args['program_post'] ) ); ?></a></h2>
			<?php
			if ( $pedalcms_args['show_program_type'] && taxonomy_exists( 'pedalcms_program_type' ) ) :
				echo wp_kses_post( pedalcms_get_the_term_list( $pedalcms_args['program_post'], 'pedalcms_program_type', '<div class="program-type">', ',', '</div>', $pedalcms_args['link_terms'] ) );
			endif;
			?>
		</header>
		<?php
		if ( $pedalcms_args['show_program_meta'] ) :
			pedalcms_get_template_part(
				'archive-program/program-meta',
				[
					'post'       => $pedalcms_args['program_post'],
					'link_terms' => $pedalcms_args['link_terms'],
				]
			);
		endif;
		?>
	</div>

	<?php
	if ( $pedalcms_args['show_program_actions'] ) :
		pedalcms_get_template_part(
			'single-program/program-actions',
			[
				'post'          => $pedalcms_args['program_post'],
				'add_permalink' => true,
			]
		);
	endif;
	?>
</article>
	<?php
endif;
