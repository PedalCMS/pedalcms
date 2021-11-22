<?php
/**
 * The template for displaying a single program.
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
<article
	id="<?php nvis_article_id_attr('', true); ?>"
	<?php post_class(); ?>>
	<?php
    nvis_prog_get_template_part('common/breadcrumbs');
    nvis_prog_get_template_part('single-program/page-header');
    ?>
	<div class="program-main entry-content">
		<?php nvis_prog_get_template_part('single-program/subpages/' . nvis_prog_get_active_subpage()); ?>
	</div>
	<?php nvis_prog_get_template_part('single-program/sidebar'); ?>
</article>
<?php nvis_prog_get_template_part('common/footer');
