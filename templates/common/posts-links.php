<?php
/**
 * Displays a simple list of post links.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! empty( $args['posts'] ) ) : ?>
<ul class="post-links">
	<?php foreach ( $args['posts'] as $linked_post ) : ?>
	<li class="post-links__item">
		<a href="<?php echo esc_url( get_permalink( $linked_post ) ); ?>"><?php echo esc_html( get_the_title( $linked_post ) ); ?></a>
	</li>
	<?php endforeach; ?>
</ul>
	<?php
endif;
