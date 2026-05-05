<?php
/**
 * The template for displaying a list of posts, for use on the News subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$program_post = pdl_args_or_global( 'post', $args );

$defaults = [
	'featured_posts'       => null,
	'posts'                => null,
	'news_tag'             => get_field( 'news_tag', $program_post ),
	'show_all_posts_link'  => get_field( 'news_show_all_link', $program_post ),
	'label_all_posts'      => pdl_get_label( 'show_all_posts' ),
	'label_no_posts_found' => pdl_get_post_type_label( 'post', 'not_found' ),
];

$args = pdl_parse_template_args( $args, $defaults, $template );

$featured_posts = $args['featured_posts'] ?? get_field( 'news_featured_posts', $program_post );
$related_posts  = $args['posts'];

if ( empty( $related_posts ) && false !== $related_posts ) {
	$not_in        = ! empty( $featured_posts ) ?
		array_column( $featured_posts, 'ID' ) :
		[];
	$related_posts = pdl_get_related_posts( $program_post, $not_in );
}

$term_link = $args['news_tag'] ? get_term_link( (int) $args['news_tag'] ) : '';

if ( ! empty( $featured_posts ) || ! empty( $related_posts ) ) : ?>

	<?php if ( ! empty( $featured_posts ) ) : ?>
<div class="related-post-list related-post-list--featured">
		<?php
		foreach ( $featured_posts as $p ) :
			pdl_get_template_part(
				'single-program/news-item',
				[
					'post'        => $p,
					'is_featured' => true,
				]
			);
		endforeach;
		?>
</div>
	<?php endif; ?>

	<?php if ( ! empty( $related_posts ) ) : ?>
<div class="related-post-list">
		<?php
		foreach ( $related_posts as $p ) :
			pdl_get_template_part( 'single-program/news-item', [ 'post' => $p ] );
		endforeach;
		?>
</div>
	<?php endif; ?>

	<?php if ( $args['show_all_posts_link'] && ! is_wp_error( $term_link ) ) : ?>
<a class="all-posts-link button button-secondary"
	href="<?php echo esc_url( $term_link ); ?>"><?php echo esc_html( $args['label_all_posts'] ); ?></a>
	<?php endif; ?>

<?php else : ?>
<p class="empty-state-message"><?php echo esc_html( $args['label_no_posts_found'] ); ?>
</p>
	<?php
endif;
