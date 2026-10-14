<?php
/**
 * The template for displaying a single course.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

if ( ! \PedalCMS\Core\Plugin::is_rendering_block_template() ) {
	pedalcms_get_template_part( 'common/header' );
}
?>
<article <?php post_class(); ?>>
	<?php
	pedalcms_get_template_part( 'common/breadcrumbs' );
	pedalcms_get_template_part( 'single-course/page-header' );
	?>
	<div class="course-main entry-content">
		<p class="course-description"><?php echo esc_html( $post->pedalcms_short_description ); ?>
		</p>
		<div class="course-content"><?php the_content(); ?>
		</div>
	</div>
	<?php pedalcms_get_template_part( 'single-course/sidebar' ); ?>
</article>
<?php
if ( ! \PedalCMS\Core\Plugin::is_rendering_block_template() ) {
	pedalcms_get_template_part( 'common/footer' );
}
