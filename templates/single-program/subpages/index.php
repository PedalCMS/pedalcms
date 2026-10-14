<?php
/**
 * The template for displaying the Program Overview Subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div <?php pedalcms_subpage_class(); ?>>
	<div class="program-overview-content">
	<?php pedalcms_the_field( 'pedalcms_overview_content' ); ?>
	</div>
</div>
