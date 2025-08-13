<?php
/**
 * Displays a single Program item, for use in an archive or other Program list.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$post = pdl_args_or_global( 'post', $args );

$defaults = [
	'show_image'           => true,
	'show_program_type'    => true,
	'show_program_meta'    => true,
	'show_program_actions' => true,
	'link_terms'           => false,
	'wrapper_class'        => '',
];

$args = pdl_parse_template_args( $args, $defaults, $template );

if ( $post ) : ?>
<article <?php post_class( $args['wrapper_class'], $post ); ?>>

	<?php
	if ( $args['show_image'] ) :
		pdl_get_template_part(
			'common/post-featured-image',
			[
				'post'        => $post,
				'image_size'  => 'medium',
				'image_align' => 'left',
				'link_image'  => true,
				'context'     => $template,
			]
		);
	endif;
	?>

	<div class="program-info item-info">
		<header>
			<h2 class="program-title entry-title"><a
					href="<?php echo get_the_permalink( $post ); ?>"><?php echo get_the_title( $post ); ?></a></h2>
			<?php
			if ( $args['show_program_type'] && taxonomy_exists( 'pdl_program_type' ) ) :
				echo pdl_get_the_term_list( $post, 'pdl_program_type', '<div class="program-type">', ',', '</div>', $args['link_terms'] );
			endif;
			?>
		</header>
		<?php
		if ( $args['show_program_meta'] ) :
			pdl_get_template_part(
				'archive-program/program-meta',
				[
					'post'       => $post,
					'link_terms' => $args['link_terms'],
				]
			);
		endif;
		?>
	</div>

	<?php
	if ( $args['show_program_actions'] ) :
		pdl_get_template_part(
			'single-program/program-actions',
			[
				'post'          => $post,
				'add_permalink' => true,
			]
		);
	endif;
	?>
</article>
	<?php
endif;
