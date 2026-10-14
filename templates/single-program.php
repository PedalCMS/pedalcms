<?php
/**
 * The template for displaying a single program.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

// Prime the cache. We will be getting a lot of meta.
get_post_meta( get_the_ID() );

if ( ! \PedalCMS\Core\Plugin::is_rendering_block_template() ) {
	pedalcms_get_template_part( 'common/header' );
}
?>
<article
	id="<?php pedalcms_article_id_attr( '', true ); ?>"
	<?php post_class(); ?>>
	<?php
	pedalcms_get_template_part( 'common/breadcrumbs' );
	pedalcms_get_template_part( 'single-program/page-header' );
	?>
	<div class="program-main entry-content">
		<?php pedalcms_get_template_part( 'single-program/subpages/' . pedalcms_get_active_subpage() ); ?>
	</div>
	<?php pedalcms_get_template_part( 'single-program/sidebar' ); ?>
</article>
<?php
if ( ! \PedalCMS\Core\Plugin::is_rendering_block_template() ) {
	pedalcms_get_template_part( 'common/footer' );
}
