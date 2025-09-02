<?php
/**
 * The template for displaying a single curriculum section, for use on Curriculum subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="curriculum-section">
	<?php if ( isset( $args['section_title'] ) ) : ?>
	<h3 class="curriculum-section__title"><?php echo esc_html( $args['section_title'] ); ?>
	</h3>
	<?php endif; ?>
	<?php if ( isset( $args['section_content'] ) ) : ?>
	<div class="curriculum-section__content">
		<?php echo wp_kses_post( $args['section_content'] ); ?>
	</div>
	<?php endif; ?>

	<?php
	if ( isset( $args['section_content'] ) ) :
		pdl_get_template_part( 'single-program/courses-table', [ 'courses' => $args['section_courses'] ] );
	endif;
	?>
</div>
