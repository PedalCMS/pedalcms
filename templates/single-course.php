<?php
/**
 * The template for displaying a single course.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

pdl_get_template_part( 'common/header' ); ?>
<article <?php post_class(); ?>>
	<?php
	pdl_get_template_part( 'common/breadcrumbs' );
	pdl_get_template_part( 'single-course/page-header' );
	?>
	<div class="course-main entry-content">
		<p class="course-description"><?php echo esc_html( $post->short_description ); ?>
		</p>
		<div class="course-content"><?php the_content(); ?>
		</div>
	</div>
	<?php pdl_get_template_part( 'single-course/sidebar' ); ?>
</article>
<?php
pdl_get_template_part( 'common/footer' );
