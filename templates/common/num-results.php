<?php
/**
 * Template for displaying number of results in archives and filtered search.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_current_post_type = get_post_type();

if ( ! $pedalcms_current_post_type ) {
	$pedalcms_current_post_type = 'post';
}

$pedalcms_defaults = [
	'label_single_post'      => pedalcms_get_post_type_label( $pedalcms_current_post_type, 'singular_name' ),
	'label_posts'            => strtolower( pedalcms_get_post_type_label( $pedalcms_current_post_type, 'plural_not_collective', 'name' ) ),
	'label_filtered_results' => pedalcms_get_label( 'filtered_results' ),
	'label_showing'          => pedalcms_get_label( 'showing' ),
	'label_showing_of'       => pedalcms_get_label( 'showing_of' ),
	'wp_query'               => null,
];

$pedalcms_args      = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );
$pedalcms_query_obj = $pedalcms_args['wp_query'];

if ( ! $pedalcms_query_obj ) {
	global $wp_query;
	$pedalcms_query_obj = $wp_query;
}

$pedalcms_query_post_type = $pedalcms_query_obj->get( 'post_type' );
$pedalcms_query_per_page  = (int) $pedalcms_query_obj->get( 'posts_per_page' );
$pedalcms_query_page      = $pedalcms_query_obj->get( 'paged' );
$pedalcms_query_page      = $pedalcms_query_page ? $pedalcms_query_page : 1;
$pedalcms_first           = ( $pedalcms_query_page - 1 ) * $pedalcms_query_per_page + 1;
$pedalcms_last            = $pedalcms_first + ( $pedalcms_query_obj->post_count - 1 );
$pedalcms_showing_all     = $pedalcms_query_obj->found_posts === $pedalcms_query_obj->post_count;

$pedalcms_label = $pedalcms_args['label_posts'];

if ( $pedalcms_query_obj->found_posts ) {
	if ( $pedalcms_showing_all ) {
		if ( 1 === $pedalcms_query_obj->found_posts ) {
			$pedalcms_label = $pedalcms_args['label_single_post'];
		}
		$pedalcms_num_results = sprintf(
			'%s %s %s.',
			esc_html( $pedalcms_args['label_showing'] ),
			$pedalcms_query_obj->found_posts,
			$pedalcms_label
		);
	} else {
		$pedalcms_num_results = sprintf(
			esc_html( $pedalcms_args['label_showing_of'] ),
			number_format( $pedalcms_first ),
			number_format( $pedalcms_last ),
			number_format( $pedalcms_query_obj->found_posts ),
			$pedalcms_label
		);
	}
}

/**
 * Fires before the number of results is loaded.
 *
 * @since 0.1
 *
 */
do_action( 'pedalcms/careers/before_num_results' );

if ( $pedalcms_query_obj->found_posts ) : ?>
<div class="num-results">
	<?php if ( pedalcms_is_filtered_results( $pedalcms_current_post_type ) ) : ?>
	<strong class="num-results__filtered"><?php echo esc_html( $pedalcms_args['label_filtered_results'] ); ?>:</strong>
	<?php endif; ?>

	<span class="num-results__value"><?php echo esc_html( $pedalcms_num_results ); ?></span>
</div>
	<?php
endif;
/**
 * Fires after the number of results is loaded.
 *
 * @since 0.1
 *
 */
do_action( 'pedalcms/careers/after_num_results' );
