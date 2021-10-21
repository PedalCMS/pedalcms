<?php
/**
 * The template for displaying personnel archives, aka the Directory.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */
defined('ABSPATH') || exit;

global $posts;

nvis_prog_get_template_part('common/header'); ?>
<div class="person-archive-main">
    <?php nvis_prog_get_template_part('archive-person/page-header'); ?>
    <?php nvis_prog_get_template_part('archive-person/person-list', ['people' => $posts]); ?>
    <?php nvis_prog_get_template_part('common/pagination'); ?>
</div>
<?php nvis_prog_get_template_part('common/footer');
