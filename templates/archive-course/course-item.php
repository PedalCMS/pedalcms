<?php
/**
 * Displays a single Course item, for use in an archive or other Course list.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$defaults    = [
	'course_post'        => null,
	'label_more_details' => pdl_get_label( 'more_details' ),
	'label_permalink'    => pdl_get_post_type_label( 'pdl_course', 'view_item' ),
	'label_show'         => pdl_get_label( 'show' ),
	'label_hide'         => pdl_get_label( 'hide' ),
];

$args = pdl_parse_template_args( $args, $defaults, $template );


if ( $args['course_post'] instanceof WP_Post ) :
	$more_details_id = 'more-details-' . $args['course_post']->ID;
?>
<article <?php post_class( '', $args['course_post'] ); ?>>
	<header>
		<h2 class="entry-title course-title">
			<a href="<?php echo esc_url( get_the_permalink( $args['course_post'] ) ); ?>">
				<?php echo pdl_get_full_course_title( $args['course_post'] ); ?>
			</a>
		</h2>
		<?php pdl_get_template_part( 'single-course/course-meta', $args ); ?>
	</header>
	<div class="course-content">
		<?php if ( $args['course_post']->short_description ) : ?>

		<button class="pdl-toggle__trigger" aria-expanded="false"
			data-target="<?php echo esc_attr( $more_details_id ); ?>"
			data-show-label="<?php echo esc_attr( $args['label_show'] ); ?> "
			data-hide-label="<?php echo esc_attr( $args['label_hide'] ); ?> "><?php echo esc_html( $args['label_more_details'] ); ?></button>
		<div id="<?php echo esc_attr( $more_details_id ); ?>"
			class="pdl-toggle__content" hidden>
			<div class="course-details">
				<p class="course-description"><?php echo esc_html( $args['course_post']->short_description ); ?>
				</p>

				<?php
				pdl_get_template_part(
					'single-course/related-personnel',
					[
						'post'    => $args['course_post'],
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
	pdl_get_template_part(
		'single-course/course-actions',
		[
			'post'            => $args['course_post'],
			'add_permalink'   => true,
			'label_permalink' => $args['label_permalink'],
		]
	);
	?>
</article>
	<?php
endif;
