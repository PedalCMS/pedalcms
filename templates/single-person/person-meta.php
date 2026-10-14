<?php
/**
 * Displays a variety of meta items, for use in a single Person view.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_person_post = pedalcms_args_or_global( 'post', $args );

$pedalcms_defaults = [
	'link_terms' => false,
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

?>
<div class="single-person__meta">
	<div class="person-meta__item">
		<?php pedalcms_get_template_part( 'blocks/job-title', [ 'job_title' => $pedalcms_person_post->pedalcms_job_title ] ); ?>
	</div>
	<?php
	if ( taxonomy_exists( 'pedalcms_department' ) ) :
		echo wp_kses_post(
			pedalcms_get_the_term_list(
				$pedalcms_person_post,
				'pedalcms_department',
				'<div class="person-department person-meta__item">',
				', ',
				'</div>',
				$pedalcms_args['link_terms']
			)
		);
	endif;
	?>
</div>
