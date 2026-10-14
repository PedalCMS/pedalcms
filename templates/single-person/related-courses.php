<?php
/**
 * The template for displaying Courses taught by a Person.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'posts'                => pedalcms_get_field( 'pedalcms_related_person_courses' ),
	'label_courses_taught' => pedalcms_get_label( 'courses_taught' ),
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

if ( ! empty( $pedalcms_args['posts'] ) ) :
	?>
<div class="person-courses">
	<h2><?php echo esc_html( $pedalcms_args['label_courses_taught'] ); ?>
	</h2>
	<?php pedalcms_get_template_part( 'common/posts-links', $pedalcms_args ); ?>
</div>
	<?php
endif;
