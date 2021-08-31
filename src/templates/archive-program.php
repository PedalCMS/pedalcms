<?php nvis_prog_get_template_part('header'); ?>
<div class="programs-archive-main">
	<?php nvis_prog_get_template_part('page-header-archive'); ?>
	<?php
    global $wp_query;
    $programs = $wp_query->posts;
    nvis_prog_get_template_part('programs-list', compact('programs'));
    ?>
	<?php nvis_prog_get_template_part('pagination'); ?>
</main>
<?php nvis_prog_get_template_part('footer');
