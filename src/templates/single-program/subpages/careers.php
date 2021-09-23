<?php if (nvis_prog_show_subpage('careers')) : $program = get_queried_object(); ?>

<div class="program-careers-subpage program-subpage">
  <h2 class="section-head">Careers</h2>

  <?php nvis_prog_get_template_part('single-program/subpages/lead-content'); ?>

  <?php
    $careers = get_field('related_careers');

    if (!empty($careers)) : ?>
  <div class="program-careers-list">
    <h3>Job Titles</h3>

    <ul>
      <?php foreach ($careers as $career) : ?>
      <li>
        <a
          href="<?php echo get_permalink($career) . '?ref_prog=' . $program->post_name; ?>"><?php echo $career->post_title; ?></a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php endif; ?>

</div>

<?php endif;
