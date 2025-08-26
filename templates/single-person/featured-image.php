<?php
/**
 * The template for displaying the a featured image for a Person.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$person_post = pdl_args_or_global( 'post', $args );

$defaults = [
	'img_size'   => 'medium',
	'attributes' => null,
	'link_image' => true,
];

$args = pdl_parse_template_args( $args, $defaults, $template );

?>
<div class="person-featured-image featured-image">
	<?php
	if ( $args['link_image'] ) :
		printf( '<a href="%s">', esc_url( get_permalink( $person_post ) ) );
	endif;

	if ( has_post_thumbnail( $person_post ) ) :
		echo get_the_post_thumbnail( $person_post, $args['img_size'], $args['attributes'] );
	else :
		pdl_get_template_part( 'single-person/featured-image-placeholder' );
	endif;

	if ( $args['link_image'] ) :
		echo '</a>';
	endif;
	?>
</div>
