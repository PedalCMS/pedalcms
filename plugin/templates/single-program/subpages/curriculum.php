<?php if (nvis_prog_show_subpage('curriculum')) : ?>

<div class="program-curriculum-subpage program-subpage">
	<h2 class="section-head">Curriculum</h2>

	<?php nvis_prog_get_template_part('single-program/subpages/lead-content'); ?>
	<?php
    $sections = get_field('curriculum_sections');

    foreach ($sections as $section) :
        nvis_prog_get_template_part('single-program/curriculum-section', $section);
    endforeach;
    ?>
</div>

<?php endif;
