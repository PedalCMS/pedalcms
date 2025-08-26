<?php
/**
 * The template for displaying a Program contact person.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$contact_post = $args['post'];

if ( $contact_post ) :
	?>
<div class="program-contact">
	<?php echo get_the_post_thumbnail( $contact_post, 'thumbnail', [ 'class' => 'program-contact__picture' ] ); ?>
	<div class="program-contact__name"><?php echo esc_html( get_the_title( $contact_post ) ); ?>
	</div>
	<?php pdl_get_template_part( 'blocks/job-title', [ 'job_title' => $contact_post->job_title ] ); ?>
	<?php pdl_get_template_part( 'blocks/contact-info', [ 'post' => $contact_post ] ); ?>
</div>
	<?php
endif;
