<?php
/**
 * The template for displaying personnel archives, aka the Directory.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */
defined( 'ABSPATH' ) || exit;

global $posts;

if ( ! \PedalCMS\Core\Plugin::is_rendering_block_template() ) {
	pdl_get_template_part( 'common/header' );
}
?>
<div class="person-archive-main">
	<?php
	pdl_get_template_part( 'common/breadcrumbs' );
	pdl_get_template_part( 'archive-person/page-header' );
	pdl_get_template_part( 'archive-person/filters' );
	pdl_get_template_part( 'archive-person/num-results' );
	pdl_get_template_part( 'archive-person/person-list', [ 'people' => $posts ] );
	pdl_get_template_part( 'common/pagination' );
	?>
</div>
<?php
if ( ! \PedalCMS\Core\Plugin::is_rendering_block_template() ) {
	pdl_get_template_part( 'common/footer' );
}
