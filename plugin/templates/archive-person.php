<?php
defined('ABSPATH') || exit;

nvis_prog_get_template_part('common/header'); ?>
<div class="person-archive-main">
    <?php nvis_prog_get_template_part('archive-person/page-header'); ?>
    <?php
    global $wp_query;
    $people = $wp_query->posts;
    nvis_prog_get_template_part('archive-person/person-list', compact('people'));
    ?>
    <?php nvis_prog_get_template_part('common/pagination'); ?>
</div>
<?php nvis_prog_get_template_part('common/footer');
