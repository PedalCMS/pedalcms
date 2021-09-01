<?php
$course = $data['course'] ?? null;

if ($course) :
    $url_more_info = nvis_prog_get_course_action_link('more_info', $course);
    $url_reg_search = nvis_prog_get_course_action_link('reg_search', $course);
?>
<details class="program-course nvis-expandable">
    <summary class="program-course__title">
        <?php echo get_the_title($course); ?>
    </summary>
    <div class="program-course__content-wrapper nvis-expandable__contents">
        <div class="program-course__content">
            <?php echo apply_filters('the_content', $course->post_content); ?>
        </div>

        <div class="program-course__actions">
            <?php if ($url_more_info) :?>
            <a href="<?php echo esc_url($url_more_info); ?>">More
                info</a>
            <?php endif; ?>

            <?php if ($url_more_info && $url_reg_search) :?>
            &nbsp; | &nbsp;
            <?php endif; ?>

            <?php if ($url_reg_search) :?>
            <a href="<?php echo esc_url($url_reg_search); ?>">Search
                for Sections</a>
            <?php endif; ?>
        </div>
    </div>
</details>
<?php endif;
