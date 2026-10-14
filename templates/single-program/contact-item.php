<?php
/**
 * The template for displaying a Program contact person.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_contact_post = get_post( $args['post'] );

if ( $pedalcms_contact_post ) :
	?>
<div class="program-contact">
	<?php echo get_the_post_thumbnail( $pedalcms_contact_post, 'thumbnail', [ 'class' => 'program-contact__picture' ] ); ?>
	<div class="program-contact__name"><?php echo esc_html( get_the_title( $pedalcms_contact_post ) ); ?>
	</div>
	<?php pedalcms_get_template_part( 'blocks/job-title', [ 'job_title' => $pedalcms_contact_post->pedalcms_job_title ] ); ?>
	<?php pedalcms_get_template_part( 'blocks/contact-info', [ 'post' => $pedalcms_contact_post ] ); ?>
</div>
	<?php
endif;
