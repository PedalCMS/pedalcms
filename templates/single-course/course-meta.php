<?php
/**
 * The template for displaying the single Course page header.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$course_post = pdl_args_or_global( 'post', $args );

$defaults = [
	'label_credit'     => pdl_get_label( 'credit' ),
	'label_credits'    => pdl_get_label( 'credits' ),
	'label_offered_in' => pdl_get_label( 'offered_in' ),
	'link_terms'       => false,
];

$args = pdl_parse_template_args( $args, $defaults, $template );

?>
<div class="course-meta">

	<?php if ( $course_post->credits ) : ?>
	<div class="course-credits">
		<?php
			echo (int) $course_post->credits . ' ';
			echo 1 === $course_post->credits ?
				esc_html( $args['label_credit'] ) :
				esc_html( $args['label_credits'] );
		?>
	</div>
	<?php endif; ?>

	<?php
	if ( taxonomy_exists( 'pdl_session' ) ) :
		echo wp_kses_post(
			pdl_get_the_term_list(
				$course_post,
				'pdl_session',
				sprintf( '<div class="course-terms-offered">%s ', esc_html( $args['label_offered_in'] ) ),
				', ',
				'</div>',
				$args['link_terms']
			)
		);
	endif;
	?>
</div>
