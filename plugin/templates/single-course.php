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
	<?php nvis_prog_get_template_part('single-course/page-header'); ?>
	<div class="program-main entry-content">
		<?php the_content(); ?>
		<?php nvis_prog_get_template_part('single-course/related-personnel'); ?>
	</div>
</article>
<?php nvis_prog_get_template_part('common/footer');
