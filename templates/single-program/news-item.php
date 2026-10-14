<?php
/**
 * The template for displaying a single Post item, for use on the News subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'post'                => null,
	'is_featured'         => false,
	'show_featured_label' => false,
	'show_image'          => true,
	'show_category'       => true,
	'show_excerpt'        => true,
	'show_permalink'      => true,
	'link_terms'          => true,
	'image_align'         => 'right',
	'image_size'          => 'small',
	'image_wrapper_class' => 'related-post__image-wrapper',
	'label_featured'      => pedalcms_get_label( 'featured' ),
	'label_read_more'     => pedalcms_get_label( 'read_more' ),
];

$pedalcms_args               = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );
$pedalcms_args['context']    = $template;
$pedalcms_args['link_image'] = true;

if ( $pedalcms_args['post'] ) :
	$pedalcms_news_post    = $pedalcms_args['post'];
	$pedalcms_args['post'] = $pedalcms_news_post; // Update args to use the renamed variable
	$pedalcms_classes      = [ 'related-post' ];

	if ( $pedalcms_args['is_featured'] ) {
		$pedalcms_classes[] = 'related-post--featured';
	}

	if ( has_post_thumbnail( $pedalcms_news_post ) ) {
		$pedalcms_classes[] = 'related-post--has-image';
	}

	$pedalcms_classes[] = 'related-post--image-' . esc_attr( $pedalcms_args['image_align'] );

	?>
<article
	class="<?php echo esc_attr( implode( ' ', $pedalcms_classes ) ); ?>">

	<?php
	if ( $pedalcms_args['show_image'] && has_post_thumbnail( $pedalcms_news_post ) ) :
		pedalcms_get_template_part( 'common/post-featured-image', $pedalcms_args );
	endif;
	?>

	<div class="related-post__wrapper">
		<header class="related-post__header">
			<h3 class="related-post__title">
				<a
					href="<?php echo esc_url( get_permalink( $pedalcms_news_post ) ); ?>">
					<?php echo esc_html( get_the_title( $pedalcms_news_post ) ); ?>
				</a>
			</h3>

			<?php if ( $pedalcms_args['is_featured'] && $pedalcms_args['show_featured_label'] ) : ?>
			<span class="related-post__title-label label"><?php echo esc_html( $pedalcms_args['label_featured'] ); ?></span>
			<?php endif; ?>

			<?php
			if ( $pedalcms_args['show_category'] ) :
				echo wp_kses_post(
					pedalcms_get_the_term_list(
						$pedalcms_news_post,
						'category',
						'<span class="related-post__category">',
						',',
						'</span>',
						$pedalcms_args['link_terms']
					)
				);
			endif;
			?>
		</header>

		<?php if ( $pedalcms_args['show_excerpt'] ) : ?>
		<div class="related-post__content"><?php echo wp_kses_post( get_the_excerpt( $pedalcms_news_post ) ); ?>
		</div>
		<?php endif; ?>

		<?php if ( $pedalcms_args['show_permalink'] ) : ?>
		<p class="related-post__more">
			<a class="related-post__more-link"
				href="<?php echo esc_url( get_permalink( $pedalcms_news_post ) ); ?>">
				<?php echo esc_html( $pedalcms_args['label_read_more'] ); ?>
			</a>
		</p>
		<?php endif; ?>

	</div>
</article>
	<?php
endif;
