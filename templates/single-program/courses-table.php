<?php
/**
 * The template for displaying a table of Courses, for use on Curriculum subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'courses'       => null,
	'show_credits'  => true,
	'label_course'  => pedalcms_get_post_type_label( 'pedalcms_course', 'singular_name' ),
	'label_credits' => ucfirst( pedalcms_get_label( 'credits' ) ),
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

if ( is_array( $pedalcms_args['courses'] ) ) : ?>
<table class="courses-table">
	<thead class="courses-table__header">
		<th><?php echo esc_html( $pedalcms_args['label_course'] ); ?>
		</th>
		<?php if ( $pedalcms_args['show_credits'] ) : ?>
		<th><?php echo esc_html( $pedalcms_args['label_credits'] ); ?>
		</th>
		<?php endif; ?>
	</thead>
	<tbody class="courses-table__body">
		<?php foreach ( $pedalcms_args['courses'] as $pedalcms_course_post ) : ?>
		<tr class="courses-table__course">
			<td>
				<a href="<?php the_permalink( $pedalcms_course_post ); ?>"><?php echo esc_html( pedalcms_get_full_course_title( $pedalcms_course_post ) ); ?></a>
			</td>

			<?php if ( $pedalcms_args['show_credits'] ) : ?>
			<td><?php echo (int) $pedalcms_course_post->pedalcms_credits; ?>
			</td>
			<?php endif; ?>

		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
	<?php
endif;
