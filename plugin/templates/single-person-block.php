<?php
/**
 * The template for displaying a person when block editor enabled on personnel.
 *
 * @package PedalCMS
 * @subpackage Templates
 * @version 1.0
 */
defined('ABSPATH') || exit;

// Prime the cache. We will be getting a lot of meta.
get_post_meta(get_the_ID());

pdl_get_template_part('common/header');
?>
<article <?php post_class(); ?>>
	<?php
    pdl_get_template_part('common/breadcrumbs');
    pdl_get_template_part('single-person/page-header');
    ?>
	<div class="program-main entry-content">
		<?php the_content(); ?>
	</div>
</article>
<?php pdl_get_template_part('common/footer');
