<?php
$pedalcms_defaults = [
	'title_tag'          => 'h2',
	'show_image'         => true,
	'show_description'   => true,
	'show_num_posts'     => true,
	'show_posts_link'    => true,
	'label_posts'        => 'Posts',
	'label_posts_single' => 'Post',
	'label_sr_text'      => 'in %s',
	'posts_link_prefix'  => 'Show',
	'wrapper_class'      => '',
	'columns'            => 2,
	'image_size'         => 'medium',
];

$pedalcms_args              = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );
$pedalcms_args['title_tag'] = pedalcms_sanitize_title_tag( $pedalcms_args['title_tag'], $pedalcms_defaults['title_tag'] );

$pedalcms_args['columns'] = max( 1, min( 4, $pedalcms_args['columns'] ) );

$pedalcms_classes = [
	'terms-grid',
	$pedalcms_args['show_image'] ? 'has-images' : 'no-images',
	$pedalcms_args['wrapper_class'],
];

if ( ! empty( $pedalcms_args['terms'] ) ) :
	$pedalcms_classes[] = ( $pedalcms_args['terms'][0] )->taxonomy . '-terms-grid';
	?>
<ul class="<?php echo esc_attr( implode( ' ', $pedalcms_classes ) ); ?>"
	data-columns="<?php echo esc_attr( $pedalcms_args['columns'] ); ?>">
	<?php
	foreach ( $pedalcms_args['terms'] as $pedalcms_grid_term ) :
		?>
	<li class="term">
		<div class="term__title-group">
			<?php printf( '<%s class="term__title">', esc_html( $pedalcms_args['title_tag'] ) ); ?>
			<a
				href="<?php echo esc_url( get_term_link( $pedalcms_grid_term, $pedalcms_grid_term->taxonomy ) ); ?>"><?php echo esc_html( $pedalcms_grid_term->name ); ?></a>
			<?php printf( '</%s>', esc_html( $pedalcms_args['title_tag'] ) ); ?>
		</div>

		<?php
		if ( $pedalcms_args['show_image'] ) :
			$pedalcms_args['term'] = $pedalcms_grid_term;
			pedalcms_get_template_part( 'common/term-featured-image', $pedalcms_args );
		endif;
		?>

		<?php if ( $pedalcms_args['show_description'] ) : ?>
		<div class="term__description"><?php echo wp_kses_post( $pedalcms_grid_term->description ); ?>
		</div>
		<?php endif; ?>

		<?php if ( $pedalcms_args['show_posts_link'] ) : ?>
		<div class="term__posts-link">
			<a
				href="<?php echo esc_url( get_term_link( $pedalcms_grid_term, $pedalcms_grid_term->taxonomy ) ); ?>">
				<?php
				printf(
					'%s %s %s',
					esc_html( $pedalcms_args['posts_link_prefix'] ),
					$pedalcms_args['show_num_posts'] ? number_format( (int) $pedalcms_grid_term->count ) : '',
					esc_html( $pedalcms_args['label_posts'] )
				);
				?>
				<span class="screen-reader-text"><?php printf( esc_html( $pedalcms_args['label_sr_text'] ), esc_html( $pedalcms_grid_term->name ) ); ?>
				</span>
			</a>
		</div>
		<?php endif; ?>

	</li>
	<?php endforeach; ?>
</ul>
	<?php
endif;
