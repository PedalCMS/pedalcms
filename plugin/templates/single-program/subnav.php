<?php
defined('ABSPATH') || exit;

if (nvis_prog_show_subpages()) : $subpages = nvis_prog_get_subpages(); ?>

<nav class="program-subnav">
  <ul class="program-subnav__menu menu">
    <?php
      foreach ($subpages as $slug => $label) :
        if (nvis_prog_show_subpage($slug)) :
    ?>
    <li
      class="<?php echo nvis_prog_is_active_subpage($slug) ? 'active-subpage' : ''; ?>">
      <span><a href="<?php nvis_prog_subpage_link($slug); ?>"><?php echo $label; ?></a></span>
    </li>
    <?php endif; endforeach; ?>
  </ul>
</nav>

<?php endif;
