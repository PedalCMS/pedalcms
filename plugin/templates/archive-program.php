<?php nvis_prog_get_template_part('common/header'); ?>
<div class="programs-archive-main">
    <?php nvis_prog_get_template_part('archive-program/page-header'); ?>
    <?php
    global $wp_query;
    $programs = $wp_query->posts;
    nvis_prog_get_template_part('archive-program/program-list', compact('programs'));
    ?>
    <?php nvis_prog_get_template_part('common/pagination'); ?>
</div>
<?php nvis_prog_get_template_part('common/footer');
