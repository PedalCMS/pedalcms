<?php
/**
 * Displays a list of Person items, for use in an archive.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;
?>
<section class="person-list">
    <?php
    if (is_array($data['people']) && !empty($data['people'])) :
        foreach ($data['people'] as $post) :
            nvis_prog_get_template_part('archive-person/person-item', compact('post'));
        endforeach;
    else: ?>

    <p class="empty-state-message">No one was found.</p>

    <?php endif; ?>
</section>