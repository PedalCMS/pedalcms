<?php
/**
 * The template for displaying a single FAQ item, for use on the FAQ subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_faq = $args['faq'] ?? null;

if ( $pedalcms_faq ) : ?>
<details class="program-faq pdl-expandable">
	<summary class="program-faq__question"><?php echo esc_html( $pedalcms_faq['question'] ); ?>
	</summary>
	<div class="program-faq__answer pdl-expandable__contents"><?php echo wp_kses_post( $pedalcms_faq['answer'] ); ?>
	</div>
</details>
	<?php
endif;
