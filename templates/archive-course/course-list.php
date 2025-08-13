<?php
/**
 * Displays a list of Course items, for use in an archive.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$defaults = [
	'courses'                => null,
	'label_no_courses_found' => pdl_get_post_type_label( 'pdl_course', 'not_found' ),
];

$args = pdl_parse_template_args( $args, $defaults, $template );

?>
<section class="course-list article-list">
	<?php
	if ( is_array( $args['courses'] ) && ! empty( $args['courses'] ) ) :
		foreach ( $args['courses'] as $post ) :
			pdl_get_template_part( 'archive-course/course-item', compact( 'post' ) );
		endforeach;
	else :
		?>

	<p class="empty-state-message"><?php echo esc_html( $args['label_no_courses_found'] ); ?>
	</p>

	<?php endif; ?>
</section>
