<?php
/**
 * The template for displaying a person when classic editor enabled on personnel.
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
	<?php nvis_prog_get_template_part('single-person/page-header-classic'); ?>
	<div class="person-main entry-content">
		<?php the_content(); ?>
		<?php nvis_prog_get_template_part('single-person/related-courses'); ?>
	</div>
</article>
<?php nvis_prog_get_template_part('common/footer');
