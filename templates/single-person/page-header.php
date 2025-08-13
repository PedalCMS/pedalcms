<?php
/**
 * The template for displaying the single Person page header when using the Block Editor.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

?>
<header class="single-person-page-header page-header entry-header">
	<?php pdl_get_template_part( 'common/breadcrumbs' ); ?>
	<h1 class="page-title entry-title">
		<?php the_title(); ?>
	</h1>
</header><!-- .page-header -->
