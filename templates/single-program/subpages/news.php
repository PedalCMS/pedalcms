<?php
/**
 * The template for displaying the News Program Subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_program_post = pedalcms_args_or_global( 'post', $args );

$pedalcms_defaults = [
	'show_subpage'  => pedalcms_show_subpage( 'news' ),
	'subpage_title' => pedalcms_get_label( 'news' ),
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

if ( $pedalcms_args['show_subpage'] ) : ?>

<div <?php pedalcms_subpage_class(); ?>>
	<h2 class="program-subpage__title"><?php echo esc_html( pedalcms_subpage_title() ); ?></h2>

	<div class="program-subpage__content">
		<?php
			pedalcms_get_template_part( 'single-program/subpages/lead-content' );
			pedalcms_get_template_part(
				'single-program/related-posts',
				[
					'post'    => $pedalcms_program_post,
					'context' => $template,
				]
			);
		?>
	</div>
</div>

	<?php
endif;
