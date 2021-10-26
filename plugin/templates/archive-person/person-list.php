<?php
/**
 * Displays a list of Person items, for use in an archive.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$show_contact_info_labels = $args['show_contact_info_labels'] ?? false;
?>
<section class="person-list">
    <?php
    if (is_array($args['people']) && !empty($args['people'])) :
        foreach ($args['people'] as $post) :
            nvis_prog_get_template_part('archive-person/person-item', compact('post', 'show_contact_info_labels'));
        endforeach;
    else: ?>

    <p class="empty-state-message">No one was found.</p>

    <?php endif; ?>
</section>