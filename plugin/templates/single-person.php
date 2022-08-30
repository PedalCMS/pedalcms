<?php
/**
 * The template for displaying a person when classic editor enabled on personnel.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

nvis_prog_get_template_part('common/header');
?>
<article <?php post_class(); ?>>

	<?php nvis_prog_get_template_part('common/breadcrumbs'); ?>
	<?php nvis_prog_get_template_part('single-person/page-header-classic'); ?>

	<div class="person-main">
		<div class="person-content entry-content">
			<?php the_content(); ?>
		</div>
		<?php nvis_prog_get_template_part('single-person/sidebar'); ?>
	</div>
</article>
<?php nvis_prog_get_template_part('common/footer');
