<?php
defined('ABSPATH') || exit;

if (nvis_prog_show_subpage('apply')) : ?>

<div class="program-apply-subpage program-subpage">
  <h2 class="section-head">How to Apply</h2>
  <div class="program-apply-content">
    <?php the_field('apply_content'); ?>
  </div>
</div>

<?php endif;
