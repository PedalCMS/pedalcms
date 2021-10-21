<?php
/**
 * Displays a list of Program items, for use in an archive.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

 defined('ABSPATH') || exit;
?>
<section class="programs-list">
    <?php if (is_array($args['programs']) && !empty($args['programs'])) :
        foreach ($args['programs'] as $post) :
            nvis_prog_get_template_part('archive-program/program-item', compact('post'));
        endforeach;
    else: ?>

    <p class="empty-state-message">No programs were found.</p>

    <?php endif; ?>
</section>