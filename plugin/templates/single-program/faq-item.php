<?php
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
