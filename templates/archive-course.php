<?php
/**
 * The template for displaying course archives.
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
<div class="course-archive-main">
	<?php
	pedalcms_get_template_part( 'common/breadcrumbs' );
	pedalcms_get_template_part( 'archive-course/page-header' );
	pedalcms_get_template_part( 'archive-course/filters' );
	pedalcms_get_template_part( 'archive-course/num-results' );
	pedalcms_get_template_part( 'archive-course/course-list', [ 'courses' => $posts ] );
	pedalcms_get_template_part( 'common/pagination' );
	?>
</div>
<?php
if ( ! \PedalCMS\Core\Plugin::is_rendering_block_template() ) {
	pedalcms_get_template_part( 'common/footer' );
}
