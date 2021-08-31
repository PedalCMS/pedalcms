<div class="program-actions">
  <ul>
    <?php if (isset($data['add_permalink'])) : ?>
    <li>
        <a class="program-details-button button button-primary" href="<?php echo esc_url($data['add_permalink']);?>">Program Details</a>
    </li>
    <?php endif; ?>

    <?php
    $action = 'apply_now';
    $url = nvis_prog_get_action_link($action);

    if ($url) :
    ?>
      <li>
        <a class="<?php echo $action; ?>-button button button-primary" href="<?php echo esc_url($url); ?>">Apply Now</a>
      </li>
    <?php endif; ?>

    <?php
    $action = 'request_info';
    $url = nvis_prog_get_action_link($action);

    if ($url) :
    ?>
      <li>
        <a class="<?php echo $action; ?>-button button button-secondary" href="<?php echo esc_url($url); ?>">Request Info</a>
      </li>
    <?php endif; ?>
  </ul>
</div>