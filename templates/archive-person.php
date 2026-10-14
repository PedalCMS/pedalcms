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
	pedalcms_get_template_part( 'common/header' );
}
?>
<div class="person-archive-main">
	<?php
	pedalcms_get_template_part( 'common/breadcrumbs' );
	pedalcms_get_template_part( 'archive-person/page-header' );
	pedalcms_get_template_part( 'archive-person/filters' );
	pedalcms_get_template_part( 'archive-person/num-results' );
	pedalcms_get_template_part( 'archive-person/person-list', [ 'people' => $posts ] );
	pedalcms_get_template_part( 'common/pagination' );
	?>
</div>
<?php
if ( ! \PedalCMS\Core\Plugin::is_rendering_block_template() ) {
	pedalcms_get_template_part( 'common/footer' );
}
