<?php
/**
 * The template for displaying the Careers Program Subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_program_post = pedalcms_args_or_global( 'post', $args );

$pedalcms_defaults = [
	'show_subpage' => pedalcms_show_subpage( 'careers' ),
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

if ( $pedalcms_args['show_subpage'] ) :
	$pedalcms_careers = pedalcms_get_field( 'pedalcms_related_program_careers', $pedalcms_program_post );
	?>

<div <?php pedalcms_subpage_class(); ?>>
	<h2 class="program-subpage__title"><?php echo esc_html( pedalcms_subpage_title() ); ?></h2>
	<?php pedalcms_get_template_part( 'single-program/subpages/lead-content' ); ?>

	<?php
	if ( ! empty( $pedalcms_careers ) ) :
		if ( function_exists( 'pedalcms_car_get_template_part' ) ) :
			pedalcms_car_get_template_part(
				'archive-career/career-list',
				[
					'posts'                 => $pedalcms_careers,
					'title_tag'             => 'h3',
					'transpose_table'       => false,
					'show_related_programs' => false,
				]
			);
		else :
			pedalcms_get_template_part( 'common/posts-links', [ 'posts' => $pedalcms_careers ] );
		endif;
	endif;
	?>
</div>

	<?php
endif;
