<?php
/**
 * The template for displaying a list of posts, for use on the News subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_program_post = pedalcms_args_or_global( 'post', $args );

$pedalcms_defaults = [
	'featured_posts'       => null,
	'posts'                => null,
	'news_tag'             => pedalcms_get_field( 'pedalcms_news_tag', $pedalcms_program_post ),
	'show_all_posts_link'  => pedalcms_get_field( 'pedalcms_news_show_all_link', $pedalcms_program_post ),
	'label_all_posts'      => pedalcms_get_label( 'show_all_posts' ),
	'label_no_posts_found' => pedalcms_get_post_type_label( 'post', 'not_found' ),
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

$pedalcms_featured_posts = $pedalcms_args['featured_posts'] ?? pedalcms_get_field( 'pedalcms_news_featured_posts', $pedalcms_program_post );
$pedalcms_related_posts  = $pedalcms_args['posts'];

if ( empty( $pedalcms_related_posts ) && false !== $pedalcms_related_posts ) {
	$pedalcms_not_in        = ! empty( $pedalcms_featured_posts ) ?
		array_column( $pedalcms_featured_posts, 'ID' ) :
		[];
	$pedalcms_related_posts = pedalcms_get_related_posts( $pedalcms_program_post, $pedalcms_not_in );
}

$pedalcms_term_link = $pedalcms_args['news_tag'] ? get_term_link( (int) $pedalcms_args['news_tag'] ) : '';

if ( ! empty( $pedalcms_featured_posts ) || ! empty( $pedalcms_related_posts ) ) : ?>

	<?php if ( ! empty( $pedalcms_featured_posts ) ) : ?>
<div class="related-post-list related-post-list--featured">
		<?php
		foreach ( $pedalcms_featured_posts as $pedalcms_p ) :
			pedalcms_get_template_part(
				'single-program/news-item',
				[
					'post'        => $pedalcms_p,
					'is_featured' => true,
				]
			);
		endforeach;
		?>
</div>
	<?php endif; ?>

	<?php if ( ! empty( $pedalcms_related_posts ) ) : ?>
<div class="related-post-list">
		<?php
		foreach ( $pedalcms_related_posts as $pedalcms_p ) :
			pedalcms_get_template_part( 'single-program/news-item', [ 'post' => $pedalcms_p ] );
		endforeach;
		?>
</div>
	<?php endif; ?>

	<?php if ( $pedalcms_args['show_all_posts_link'] && ! is_wp_error( $pedalcms_term_link ) ) : ?>
<a class="all-posts-link button button-secondary"
	href="<?php echo esc_url( $pedalcms_term_link ); ?>"><?php echo esc_html( $pedalcms_args['label_all_posts'] ); ?></a>
	<?php endif; ?>

<?php else : ?>
<p class="empty-state-message"><?php echo esc_html( $pedalcms_args['label_no_posts_found'] ); ?>
</p>
	<?php
endif;
