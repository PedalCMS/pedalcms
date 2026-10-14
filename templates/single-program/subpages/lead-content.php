<?php
/**
 * The template for displaying lead content on a Program Subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_subpage = pedalcms_get_active_subpage();

if ( $pedalcms_subpage ) :
	$pedalcms_field = 'pedalcms_' . str_replace( '-', '_', $pedalcms_subpage ) . '_lead';
	$pedalcms_class = sprintf( 'program-%s-lead-content', $pedalcms_subpage );
	?>
	<?php if ( pedalcms_get_field( $pedalcms_field ) ) : ?>
<div class="<?php echo esc_attr( $pedalcms_class ); ?> program-lead-content">
		<?php pedalcms_the_field( $pedalcms_field ); ?>
</div>
<?php endif; ?>
	<?php
endif;
