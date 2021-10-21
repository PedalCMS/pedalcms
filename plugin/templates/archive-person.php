<?php
/**
 * The template for displaying personnel archives, aka the Directory.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */
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
