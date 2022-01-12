<?php
/**
 * The template for displaying a single course.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */
defined('ABSPATH') || exit;

nvis_prog_get_template_part('common/header'); ?>
<article <?php post_class(); ?>>
	<?php
    nvis_prog_get_template_part('common/breadcrumbs');
    nvis_prog_get_template_part('single-course/page-header');
    ?>
	<div class="course-main entry-content">
		<p class="course-description"><?php echo esc_html($post->short_description); ?>
		</p>
		<div class="course-content"><?php the_content(); ?>
		</div>
	</div>
	<aside class="course-sidebar nvis-sidebar">
		<?php nvis_prog_get_template_part('single-course/related-personnel'); ?>
	</aside>
</article>
<?php nvis_prog_get_template_part('common/footer');
