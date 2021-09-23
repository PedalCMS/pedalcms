<?php $person = get_post(); ?>
<div class="single-person__meta">
    <?php
    nvis_prog_get_template_part('blocks/job-title', ['job_title' => $person->job_title]);
    ?>
</div>