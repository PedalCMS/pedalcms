<?php
/**
 * The template for displaying a single FAQ item, for use on the FAQ subpage.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$faq = $data['faq'] ?? null;

if ($faq) : ?>
<details class="program-faq nvis-expandable">
  <summary class="program-faq__question"><?php echo esc_html($faq['question']); ?>
  </summary>
  <div class="program-faq__answer nvis-expandable__contents"><?php echo $faq['answer']; ?>
  </div>
</details>
<?php endif;
