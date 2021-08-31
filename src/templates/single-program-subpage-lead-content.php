<?php
  $subpage = nvis_prog_get_active_subpage();

  if ($subpage) :
    $field = $subpage . '_lead';
    $class = sprintf('program-%s-lead-content', $subpage);
?>
<?php if (get_field($field)) : ?>
  <div class="<?php echo $class; ?> program-lead-content">
    <?php the_field($field); ?>
  </div>
<?php endif; ?>
<?php endif; ?>