<?php
/**
 * The template for displaying the a featured image for a Person.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_person_post = pedalcms_args_or_global( 'post', $args );

$pedalcms_defaults = [
	'img_size'   => 'medium',
	'attributes' => null,
	'link_image' => true,
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

?>
<div class="person-featured-image featured-image">
	<?php
	if ( $pedalcms_args['link_image'] ) :
		printf( '<a href="%s">', esc_url( get_permalink( $pedalcms_person_post ) ) );
	endif;

	if ( has_post_thumbnail( $pedalcms_person_post ) ) :
		echo get_the_post_thumbnail( $pedalcms_person_post, $pedalcms_args['img_size'], $pedalcms_args['attributes'] );
	else :
		pedalcms_get_template_part( 'single-person/featured-image-placeholder' );
	endif;

	if ( $pedalcms_args['link_image'] ) :
		echo '</a>';
	endif;
	?>
</div>
