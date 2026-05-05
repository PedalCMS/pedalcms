<?php
/**
 * Displays a single Person item, for use in an archive or other Course list.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;


$defaults = [
	'person_post'              => null,
	'show_contact_info'        => true,
	'show_contact_info_labels' => false,
	'show_image'               => true,
	'link_terms'               => true,
	'img_size'                 => 'medium',
	'h_level'                  => 2,
];

$args  = pdl_parse_template_args( $args, $defaults, $template );
$h_tag = pdl_get_heading_tag( $args['h_level'] );
$person_post = get_post( $args['person_post'] );

if ( $person_post instanceof \WP_Post ) :?>
<article <?php post_class( '', $person_post ); ?>>
	<?php
	if ( $args['show_image'] ) :
		pdl_get_template_part(
			'single-person/featured-image',
			[
				'post'     => $person_post,
				'img_size' => $args['img_size'],
			]
		);
	endif;
	?>
	<div class="person-info">
		<header>
			<?php printf( '<%s class="person-name">', esc_html( $h_tag ) ); ?>
			<a href="<?php echo esc_url( get_the_permalink( $person_post ) ); ?>"><?php echo esc_html( get_the_title( $person_post ) ); ?></a>
			<?php printf( '</%s>', esc_html( $h_tag ) ); ?>
			<div class="person-position">
				<?php pdl_get_template_part( 'blocks/job-title', [ 'job_title' => $person_post->job_title ] ); ?>
				<?php
				if ( taxonomy_exists( 'pdl_department' ) ) :
					echo wp_kses_post(
						pdl_get_the_term_list(
							$person_post,
							'pdl_department',
							'<div class="person-department">',
							', ',
							'</div>',
							$args['link_terms']
						)
					);
				endif;
				?>
			</div>
		</header>
		<?php
		if ( $args['show_contact_info'] ) :
			pdl_get_template_part(
				'blocks/contact-info',
				[
					'post'        => $person_post,
					'show_labels' => $args['show_contact_info_labels'],
				]
			);
		endif;
		?>
	</div>
</article>
	<?php
endif;
