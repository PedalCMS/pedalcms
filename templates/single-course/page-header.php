<?php
/**
 * The template for displaying the single Course page header.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

?>
<header class="single-course-page-header page-header entry-header">
	<h1 class="page-title entry-title">
		<?php echo esc_html( pdl_get_full_course_title() ); ?>
	</h1>
	<?php pdl_get_template_part( 'single-course/course-meta' ); ?>
</header><!-- .page-header -->
