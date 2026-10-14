<?php
/**
 * Displays a list of Course items, for use in an archive.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'courses'                => null,
	'label_no_courses_found' => pedalcms_get_post_type_label( 'pedalcms_course', 'not_found' ),
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

?>
<section class="course-list article-list">
	<?php
	if ( is_array( $pedalcms_args['courses'] ) && ! empty( $pedalcms_args['courses'] ) ) :
		foreach ( $pedalcms_args['courses'] as $pedalcms_course_post ) :
			pedalcms_get_template_part( 'archive-course/course-item', [ 'course_post' => $pedalcms_course_post ] );
		endforeach;
	else :
		?>

	<p class="empty-state-message"><?php echo esc_html( $pedalcms_args['label_no_courses_found'] ); ?>
	</p>

	<?php endif; ?>
</section>
