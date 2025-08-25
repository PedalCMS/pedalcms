<?php
/**
 * Template for displaying number of results in archives and filtered search.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$post_type = get_post_type();

if ( ! $post_type ) {
	$post_type = 'post';
}

$defaults = [
	'label_single_post'      => pdl_get_post_type_label( $post_type, 'singular_name' ),
	'label_posts'            => strtolower( pdl_get_post_type_label( $post_type, 'plural_not_collective', 'name' ) ),
	'label_filtered_results' => pdl_get_label( 'filtered_results' ),
	'label_showing'          => pdl_get_label( 'showing' ),
	'label_showing_of'       => pdl_get_label( 'showing_of' ),
	'wp_query'               => null,
];

$args     = pdl_parse_template_args( $args, $defaults, $template );
$wp_query = $args['wp_query'];

if ( ! $wp_query ) {
	global $wp_query;
}

$post_type   = $wp_query->get( 'post_type' );
$per_page    = (int) $wp_query->get( 'posts_per_page' );
$page        = $wp_query->get( 'paged' );
$page        = $page ? $page : 1;
$first       = ( $page - 1 ) * $per_page + 1;
$last        = $first + ( $wp_query->post_count - 1 );
$showing_all = $wp_query->found_posts === $wp_query->post_count;

$label = $args['label_posts'];

if ( $wp_query->found_posts ) {
	if ( $showing_all ) {
		if ( 1 === $wp_query->found_posts ) {
			$label = $args['label_single_post'];
		}
		$num_results = sprintf(
			'%s %s %s.',
			esc_html( $args['label_showing'] ),
			$wp_query->found_posts,
			$label
		);
	} else {
		$num_results = sprintf(
			esc_html( $args['label_showing_of'] ),
			number_format( $first ),
			number_format( $last ),
			number_format( $wp_query->found_posts ),
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

if ( $wp_query->found_posts ) : ?>
<div class="num-results">
	<?php if ( pdl_is_filtered_results( $post_type ) ) : ?>
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
