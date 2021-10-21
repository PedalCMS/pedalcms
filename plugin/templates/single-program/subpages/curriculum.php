<?php
defined('ABSPATH') || exit;

if (nvis_prog_show_subpage('curriculum')) : ?>

<div class="program-curriculum-subpage program-subpage">
    <h2 class="section-head">Curriculum</h2>

    <?php nvis_prog_get_template_part('single-program/subpages/lead-content'); ?>
    <?php
    $sections = get_field('curriculum_sections');

    if (is_array($sections)) :
        foreach ($sections as $section) :
            nvis_prog_get_template_part('single-program/curriculum-section', $section);
        endforeach;
    endif;
    ?>
</div>

<?php endif;
