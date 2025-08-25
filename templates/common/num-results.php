<?php
/**
 * Template for displaying number of results in archives and filtered search.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$current_post_type = get_post_type();

if ( ! $current_post_type ) {
	$current_post_type = 'post';
}

$defaults = [
	'label_single_post'      => pdl_get_post_type_label( $current_post_type, 'singular_name' ),
	'label_posts'            => strtolower( pdl_get_post_type_label( $current_post_type, 'plural_not_collective', 'name' ) ),
	'label_filtered_results' => pdl_get_label( 'filtered_results' ),
	'label_showing'          => pdl_get_label( 'showing' ),
	'label_showing_of'       => pdl_get_label( 'showing_of' ),
	'wp_query'               => null,
];

$args      = pdl_parse_template_args( $args, $defaults, $template );
$query_obj = $args['wp_query'];

if ( ! $query_obj ) {
	global $wp_query;
	$query_obj = $wp_query;
}

$query_post_type = $query_obj->get( 'post_type' );
$query_per_page  = (int) $query_obj->get( 'posts_per_page' );
$query_page      = $query_obj->get( 'paged' );
$query_page      = $query_page ? $query_page : 1;
$first           = ( $query_page - 1 ) * $query_per_page + 1;
$last            = $first + ( $query_obj->post_count - 1 );
$showing_all     = $query_obj->found_posts === $query_obj->post_count;

$label = $args['label_posts'];

if ( $query_obj->found_posts ) {
	if ( $showing_all ) {
		if ( 1 === $query_obj->found_posts ) {
			$label = $args['label_single_post'];
		}
		$num_results = sprintf(
			'%s %s %s.',
			esc_html( $args['label_showing'] ),
			$query_obj->found_posts,
			$label
		);
	} else {
		$num_results = sprintf(
			esc_html( $args['label_showing_of'] ),
			number_format( $first ),
			number_format( $last ),
			number_format( $query_obj->found_posts ),
			$label
		);
	}
}

/**
 * Fires before the number of results is loaded.
 *
 * @since 0.1
 *
 */
do_action( 'pdl/careers/before_num_results' );

if ( $query_obj->found_posts ) : ?>
<div class="num-results">
	<?php if ( pdl_is_filtered_results( $current_post_type ) ) : ?>
	<strong class="num-results__filtered"><?php echo esc_html( $args['label_filtered_results'] ); ?>:</strong>
	<?php endif; ?>

	<span class="num-results__value"><?php echo esc_html( $num_results ); ?></span>
</div>
	<?php
endif;
/**
 * Fires after the number of results is loaded.
 *
 * @since 0.1
 *
 */
do_action( 'pdl/careers/after_num_results' );
