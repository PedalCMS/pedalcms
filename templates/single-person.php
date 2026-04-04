<?php
/**
 * The template for displaying a person when classic editor enabled on personnel.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! \PedalCMS\Core\Plugin::is_rendering_block_template() ) {
	pdl_get_template_part( 'common/header' );
}
?>
<article <?php post_class(); ?>>

	<?php pdl_get_template_part( 'common/breadcrumbs' ); ?>
	<?php pdl_get_template_part( 'single-person/page-header-classic' ); ?>

	<div class="person-main">
		<div class="person-content entry-content">
			<?php the_content(); ?>
		</div>
		<?php pdl_get_template_part( 'single-person/sidebar' ); ?>
	</div>
</article>
<?php
if ( ! \PedalCMS\Core\Plugin::is_rendering_block_template() ) {
	pdl_get_template_part( 'common/footer' );
}
