<?php
/**
 * The template for displaying a person when block editor enabled on personnel.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */
defined('ABSPATH') || exit;

// Prime the cache. We will be getting a lot of meta.
get_post_meta(get_the_ID());

nvis_prog_get_template_part('common/header');
?>
<article <?php post_class(); ?>>
	<?php nvis_prog_get_template_part('single-person/page-header'); ?>
	<div class="program-main entry-content">
		<?php the_content(); ?>
	</div>
</article>
<?php nvis_prog_get_template_part('common/footer');
