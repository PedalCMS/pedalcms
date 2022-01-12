<?php
/**
 * Displays a list of Person items, for use in an archive.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'people'                   => null,
    'show_contact_info_labels' => false,
    'label_no_one_found'       => 'No one was found.'
];

$args = wp_parse_args($args, $defaults);

?>
<section class="person-list">
    <?php
    if (is_array($args['people']) && !empty($args['people'])) :
        foreach ($args['people'] as $post) :
            nvis_prog_get_template_part('archive-person/person-item', ['post' => $post, 'show_contact_info_labels' => $args['show_contact_info_labels']]);
        endforeach;
    else: ?>

    <p class="empty-state-message"><?php echo esc_html($args['label_no_one_found']); ?>
    </p>

    <?php endif; ?>
</section>