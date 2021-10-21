<?php
defined('ABSPATH') || exit;

?>
<div class="program-meta">

  <?php
  // TODO: Link these somewhere else?
  the_terms(
      get_the_ID(),
      'nvis_program_format',
      '<div class="program-format program-meta__item">Delivery Format: ',
      ', ',
      '</div>'
  ); ?>

  <div class="program-entrance-exam program-meta__item">
    Prerequisites:
    <?php echo get_field('prerequisites') ? 'Yes' : 'No'; ?>
  </div>

  <?php
  // TODO: Link these to the college, not the archive.
  the_terms(
      get_the_ID(),
      'nvis_program_college',
      '<div class="program-college program-meta__item">College: ',
      ', ',
      '</div>'
  ); ?>

</div>