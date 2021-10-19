<?php $person = get_post(); ?>
<div class="single-person__meta">
    <div class="person-meta__item">
        <?php nvis_prog_get_template_part('blocks/job-title', ['job_title' => $person->job_title]); ?>
    </div>
    <?php
    the_terms(
    get_the_ID(),
    'nvis_department',
    '<div class="person-department person-meta__item">',
    ', ',
    '</div>'
); ?>
</div>