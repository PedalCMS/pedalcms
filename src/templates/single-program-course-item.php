<?php $course = $data['course'] ?? null; ?>

<?php if ($course) :?>
<details class="program-course nvis-expandable">
    <summary class="program-course__title">
        <?php the_field('course_id', $course); ?><span class="separator">:</span>
        <?php echo get_the_title($course); ?>
    </summary>
    <div class="program-course__content-wrapper nvis-expandable__contents">
        <div class="program-course__content">
            <?php echo apply_filters('the_content', $course->post_content); ?>
        </div>

        <div class="program-course__actions">
            <a href="#">More info</a> 
            &nbsp; | &nbsp; 
            <a href="#">Search for Sections</a>
        </div>
    </div>
</details>
<?php endif; ?>