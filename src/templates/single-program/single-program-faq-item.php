<?php $faq = $data['faq'] ?? null; ?>

<?php if ($faq) :?>
<details class="program-faq nvis-expandable">
  <summary class="program-faq__question"><?php echo get_the_title($faq); ?></summary>
  <div class="program-faq__answer nvis-expandable__contents"><?php echo apply_filters('the_content', $faq->post_content); ?></div>
</details>
<?php endif; ?>