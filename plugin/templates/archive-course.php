<?php nvis_prog_get_template_part('common/header'); ?>
<div class="course-archive-main">
    <?php nvis_prog_get_template_part('archive-course/page-header'); ?>
    <?php
    global $wp_query;
    $courses = $wp_query->posts;
    nvis_prog_get_template_part('archive-course/course-list', compact('courses'));
    ?>
    <?php nvis_prog_get_template_part('common/pagination'); ?>
</div>
<?php nvis_prog_get_template_part('common/footer');
