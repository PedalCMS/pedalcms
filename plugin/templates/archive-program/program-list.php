<?php
/**
 * Displays a list of Program items, for use in an archive.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'label_no_programs_found' => pdl_get_label('no_programs_found')
];

$args = pdl_parse_template_args($args, $defaults, $template);

?>
<section class="programs-list">
    <?php if (is_array($args['programs']) && !empty($args['programs'])) :
        foreach ($args['programs'] as $post) :
            pdl_get_template_part('archive-program/program-item', compact('post'));
        endforeach;
    else: ?>

    <p class="empty-state-message"><?php echo esc_html($args['label_no_programs_found']); ?>
    </p>

    <?php endif; ?>
</section>
