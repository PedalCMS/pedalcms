<?php
/**
 * Displays a breadcrumb trail, for use in the page header.
 *
 * Relies on third party plugins to handle rendering breadcrumbs. Supports:
 * - Breadcrumb NavXT
 * - Yoast SEO
 * - All in One SEO
 * - Rank Math
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'show_breadcrumbs'         => true,
	'breadcrumb_wrapper_id'    => 'breadcrumbs',
	'breadcrumb_wrapper_class' => 'breadcrumbs',
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

if ( $pedalcms_args['show_breadcrumbs'] ) :
	/**
	 * Fires before the breadcrumbs are loaded.
	 *
	 * @since 0.1
	 *
	 * @param $args The array of args for the template.
	 *
	 */
	do_action( 'pedalcms/before_breadcrumbs', $pedalcms_args );
	?>
<div id="<?php echo esc_attr( $pedalcms_args['breadcrumb_wrapper_id'] ); ?>"
	class="pdl-breadcrumbs <?php echo esc_attr( $pedalcms_args['breadcrumb_wrapper_class'] ); ?>">
	<?php
	if ( function_exists( 'bcn_display' ) ) {
		bcn_display();
	} elseif ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb();
	} elseif ( function_exists( 'aioseo_breadcrumbs' ) ) {
		aioseo_breadcrumbs();
	} elseif ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
		rank_math_the_breadcrumbs();
	}
	?>
</div>
	<?php
	/**
	 * Fires after the breadcrumbs are loaded.
	 *
	 * @since 0.1
	 *
	 * @param $args The array of args for the template.
	 *
	 */
	do_action( 'pedalcms/after_breadcrumbs', $pedalcms_args );

endif;
