<div class="program-course-list">
    <?php
    $courses = get_field('related_courses');

    if (!empty($courses)) :
    foreach ($courses as $course) :
        nvis_prog_get_template_part('single-program-course-item', compact('course'));
    endforeach;
    endif;
    ?>
</div>