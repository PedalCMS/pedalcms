<?php
/**
 * The template for displaying program archives.
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
<div class="programs-archive-main">
	<?php
		pedalcms_get_template_part( 'common/breadcrumbs' );
		pedalcms_get_template_part( 'archive-program/page-header' );
		pedalcms_get_template_part( 'archive-program/filters' );
		pedalcms_get_template_part( 'archive-program/num-results' );
		pedalcms_get_template_part( 'archive-program/program-list', [ 'programs' => $posts ] );
		pedalcms_get_template_part( 'common/pagination' );
	?>
</div>
<?php
if ( ! \PedalCMS\Core\Plugin::is_rendering_block_template() ) {
	pedalcms_get_template_part( 'common/footer' );
}
