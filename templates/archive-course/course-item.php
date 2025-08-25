<?php
/**
 * Displays a single Course item, for use in an archive or other Course list.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$course_post = pdl_args_or_global( 'post', $args );
$defaults    = [
	'label_more_details' => pdl_get_label( 'more_details' ),
	'label_permalink'    => pdl_get_post_type_label( 'pdl_course', 'view_item' ),
	'label_show'         => pdl_get_label( 'show' ),
	'label_hide'         => pdl_get_label( 'hide' ),
];

$args = pdl_parse_template_args( $args, $defaults, $template );

$more_details_id = 'more-details-' . $course_post->ID;

if ( $course_post ) :?>
<article <?php post_class( '', $course_post ); ?>>
	<header>
		<h2 class="entry-title course-title">
			<a href="<?php echo esc_url( get_the_permalink( $course_post ) ); ?>">
				<?php echo esc_html( pdl_get_full_course_title( $course_post ) ); ?>
			</a>
		</h2>
		<?php pdl_get_template_part( 'single-course/course-meta', compact( 'course_post' ) ); ?>
	</header>
	<div class="course-content">
		<button class="pdl-toggle__trigger" aria-expanded="false"
			data-target="<?php echo esc_attr( $more_details_id ); ?>"
			data-show-label="<?php echo esc_attr( $args['label_show'] ); ?> "
			data-hide-label="<?php echo esc_attr( $args['label_hide'] ); ?> "><?php echo esc_html( $args['label_more_details'] ); ?></button>
		<div id="<?php echo esc_attr( $more_details_id ); ?>"
			class="pdl-toggle__content" hidden>
			<div class="course-details">
				<p class="course-description"><?php echo esc_html( $course_post->short_description ); ?>
				</p>

				<?php
				pdl_get_template_part(
					'single-course/related-personnel',
					[
						'post'    => $course_post,
						'h_level' => 3,
						'style'   => 'links',
					]
				);
				?>
			</div>
		</div>
	</div>
	<?php
	pdl_get_template_part(
		'single-course/course-actions',
		[
			'post'            => $course_post,
			'add_permalink'   => true,
			'label_permalink' => $args['label_permalink'],
		]
	);
	?>
</article>
	<?php
endif;
