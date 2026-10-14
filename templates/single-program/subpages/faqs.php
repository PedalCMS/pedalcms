<?php
/**
 * The template for displaying the FAQ Program Subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_program_post = pedalcms_args_or_global( 'post', $args );

$pedalcms_defaults = [
	'show_subpage'      => pedalcms_show_subpage( 'faqs' ),
	'group_by_category' => pedalcms_get_field( 'pedalcms_faqs_by_category', $pedalcms_program_post ),
	'faqs'              => pedalcms_get_field( 'pedalcms_related_faqs_list', $pedalcms_program_post ),
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );
$pedalcms_faqs = $pedalcms_args['faqs'];

if ( $pedalcms_faqs ) {
	$pedalcms_faqs = \PedalCMS\Core\FAQ::normalize_faq_types( $pedalcms_faqs, $pedalcms_args['group_by_category'] );
}

if ( $pedalcms_args['show_subpage'] ) : ?>
<div <?php pedalcms_subpage_class(); ?>>
	<h2 class="program-subpage__title"><?php echo esc_html( pedalcms_subpage_title() ); ?></h2>

	<div class="program-subpage__content">

	<?php pedalcms_get_template_part( 'single-program/subpages/lead-content' ); ?>

	<div class="program-faq-list">
		<?php
		if ( ! empty( $pedalcms_faqs ) ) :
			if ( $pedalcms_args['group_by_category'] ) :
				foreach ( $pedalcms_faqs as $pedalcms_faq_cat ) :
					?>
		<div class="faq-category">
		<h3 id="<?php echo esc_attr( $pedalcms_faq_cat->slug ); ?>"
			class="faq-category__title">
					<?php echo esc_html( $pedalcms_faq_cat->name ); ?>
		</h3>
		<div class="faq-category__faqs">
					<?php
					foreach ( $pedalcms_faq_cat->faqs as $pedalcms_faq ) :
						pedalcms_get_template_part( 'single-program/faq-item', [ 'faq' => $pedalcms_faq ] );
					endforeach;
					?>
		</div>
		</div>
					<?php
				endforeach;
			else :
				foreach ( $pedalcms_faqs as $pedalcms_faq ) :
					pedalcms_get_template_part( 'single-program/faq-item', [ 'faq' => $pedalcms_faq ] );
			endforeach;
			endif;
		endif;
		?>
	</div>
	</div>

</div>
	<?php
endif;
