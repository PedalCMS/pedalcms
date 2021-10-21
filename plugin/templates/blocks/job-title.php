<?php

defined('ABSPATH') || exit;

if (isset($data['job_title'])) :?>
<div class="person-job-title">
    <?php echo esc_html($data['job_title']); ?>
</div>
<?php endif;
