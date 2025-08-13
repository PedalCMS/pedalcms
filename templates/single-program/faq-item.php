<?php
/**
 * The template for displaying a single FAQ item, for use on the FAQ subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$faq = $args['faq'] ?? null;

if ( $faq ) : ?>
<details class="program-faq pdl-expandable">
	<summary class="program-faq__question"><?php echo esc_html( $faq['question'] ); ?>
	</summary>
	<div class="program-faq__answer pdl-expandable__contents"><?php echo $faq['answer']; ?>
	</div>
</details>
	<?php
endif;
