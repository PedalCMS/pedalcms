<?php
/**
 * Template for displaying the Program archive page header.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'archive_title'    => null,
	'show_description' => true,
	'show_image'       => true,
	'image_align'      => 'right',
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

if ( ! $pedalcms_args['archive_title'] ) {
	$pedalcms_archive_title = pedalcms_get_archive_title();
} else {
	$pedalcms_archive_title = esc_html( $pedalcms_args['archive_title'] );
}

?>
<section
	class="<?php echo esc_attr( get_post_type() ); ?>-archive-page-header page-header">
	<?php
	pedalcms_get_template_part(
		'common/page-header-backdrop',
		[
			'context'          => $template,
			'fallback_to_post' => false,
		]
	);
	?>
	<div class="page-header__content">
	<?php
	if ( $pedalcms_args['show_image'] ) :
		if ( is_tax() && ! pedalcms_is_filtered_results( pedalcms_get_post_types() ) ) :
			pedalcms_get_template_part( 'common/term-featured-image', $pedalcms_args );
		else :
			pedalcms_get_template_part( 'common/post-type-featured-image', $pedalcms_args );
		endif;
	endif;
	?>
	<h1 class="page-title">
		<?php echo wp_kses_post( $pedalcms_archive_title ); ?>
	</h1>
	<?php if ( $pedalcms_args['show_description'] || $pedalcms_args['show_image'] ) : ?>
	<div class="archive-summary">
		<?php
		if ( $pedalcms_args['show_description'] ) :
			the_archive_description( '<div class="archive-description">', '</div>' );
		endif;
		?>
	</div>
	<?php endif; ?>
	</div>
</section><!-- .page-header -->
