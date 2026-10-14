<?php
/**
 * Displays a single Person item, for use in an archive or other Course list.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;


$pedalcms_defaults = [
	'person_post'              => null,
	'show_contact_info'        => true,
	'show_contact_info_labels' => false,
	'show_image'               => true,
	'link_terms'               => true,
	'img_size'                 => 'medium',
	'h_level'                  => 2,
];

$pedalcms_args        = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );
$pedalcms_h_tag       = pedalcms_get_heading_tag( $pedalcms_args['h_level'] );
$pedalcms_person_post = get_post( $pedalcms_args['person_post'] );

if ( $pedalcms_person_post instanceof \WP_Post ) :?>
<article <?php post_class( '', $pedalcms_person_post ); ?>>
	<?php
	if ( $pedalcms_args['show_image'] ) :
		pedalcms_get_template_part(
			'single-person/featured-image',
			[
				'post'     => $pedalcms_person_post,
				'img_size' => $pedalcms_args['img_size'],
			]
		);
	endif;
	?>
	<div class="person-info">
		<header>
			<?php printf( '<%s class="person-name">', esc_html( $pedalcms_h_tag ) ); ?>
			<a href="<?php echo esc_url( get_the_permalink( $pedalcms_person_post ) ); ?>"><?php echo esc_html( get_the_title( $pedalcms_person_post ) ); ?></a>
			<?php printf( '</%s>', esc_html( $pedalcms_h_tag ) ); ?>
			<div class="person-position">
				<?php pedalcms_get_template_part( 'blocks/job-title', [ 'job_title' => $pedalcms_person_post->pedalcms_job_title ] ); ?>
				<?php
				if ( taxonomy_exists( 'pedalcms_department' ) ) :
					echo wp_kses_post(
						pedalcms_get_the_term_list(
							$pedalcms_person_post,
							'pedalcms_department',
							'<div class="person-department">',
							', ',
							'</div>',
							$pedalcms_args['link_terms']
						)
					);
				endif;
				?>
			</div>
		</header>
		<?php
		if ( $pedalcms_args['show_contact_info'] ) :
			pedalcms_get_template_part(
				'blocks/contact-info',
				[
					'post'        => $pedalcms_person_post,
					'show_labels' => $pedalcms_args['show_contact_info_labels'],
				]
			);
		endif;
		?>
	</div>
</article>
	<?php
endif;
