<?php
/**
 * Displays a single Course item, for use in an archive or other Course list.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'course_post'        => null,
	'label_more_details' => pedalcms_get_label( 'more_details' ),
	'label_permalink'    => pedalcms_get_post_type_label( 'pedalcms_course', 'view_item' ),
	'label_show'         => pedalcms_get_label( 'show' ),
	'label_hide'         => pedalcms_get_label( 'hide' ),
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );


if ( $pedalcms_args['course_post'] instanceof \WP_Post ) :
	$pedalcms_more_details_id = 'more-details-' . $pedalcms_args['course_post']->ID;
	?>
<article <?php post_class( '', $pedalcms_args['course_post'] ); ?>>
	<header>
		<h2 class="entry-title course-title">
			<a href="<?php echo esc_url( get_the_permalink( $pedalcms_args['course_post'] ) ); ?>">
				<?php echo wp_kses_post( pedalcms_get_full_course_title( $pedalcms_args['course_post'] ) ); ?>
			</a>
		</h2>
		<?php pedalcms_get_template_part( 'single-course/course-meta', $pedalcms_args ); ?>
	</header>
	<div class="course-content">
		<?php if ( $pedalcms_args['course_post']->pedalcms_short_description ) : ?>

		<div id="<?php echo esc_attr( $pedalcms_more_details_id ); ?>"
			class="pdl-toggle__content">
			<div class="course-details">
				<p class="course-description"><?php echo esc_html( $pedalcms_args['course_post']->pedalcms_short_description ); ?>
				</p>

				<?php
				pedalcms_get_template_part(
					'single-course/related-personnel',
					[
						'post'    => $pedalcms_args['course_post'],
						'h_level' => 3,
						'style'   => 'links',
					]
				);
				?>
			</div>
		</div>

		<?php endif; ?>
	</div>
	<?php
	pedalcms_get_template_part(
		'single-course/course-actions',
		[
			'post'            => $pedalcms_args['course_post'],
			'add_permalink'   => true,
			'label_permalink' => $pedalcms_args['label_permalink'],
		]
	);
	?>
</article>
	<?php
endif;
