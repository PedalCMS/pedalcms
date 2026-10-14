<?php
/**
 * The template for displaying the single Course page header.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_course_post = pedalcms_args_or_global( 'post', $args );

$pedalcms_defaults = [
	'label_credit'     => pedalcms_get_label( 'credit' ),
	'label_credits'    => pedalcms_get_label( 'credits' ),
	'label_offered_in' => pedalcms_get_label( 'offered_in' ),
	'link_terms'       => false,
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

?>
<div class="course-meta">

	<?php if ( $pedalcms_course_post->pedalcms_credits ) : ?>
	<div class="course-credits">
		<?php
			echo (int) $pedalcms_course_post->pedalcms_credits . ' ';
			echo 1 === $pedalcms_course_post->pedalcms_credits ?
				esc_html( $pedalcms_args['label_credit'] ) :
				esc_html( $pedalcms_args['label_credits'] );
		?>
	</div>
	<?php endif; ?>

	<?php
	if ( taxonomy_exists( 'pedalcms_session' ) ) :
		echo wp_kses_post(
			pedalcms_get_the_term_list(
				$pedalcms_course_post,
				'pedalcms_session',
				sprintf( '<div class="course-terms-offered">%s ', esc_html( $pedalcms_args['label_offered_in'] ) ),
				', ',
				'</div>',
				$pedalcms_args['link_terms']
			)
		);
	endif;
	?>
</div>
