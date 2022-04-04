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
    'layout'                   => 'grid',
    'show_contact_info'        => true,
    'show_contact_info_labels' => false,
    'img_size'                 => 'medium',
    'label_no_one_found'       => nvis_get_post_type_label('nvis_person', 'not_found')
];

$args = nvis_parse_template_args($args, $defaults, $template);

$classes = [
    'person-list',
    'person-list--' . $args['layout']
];
?>
<section
    class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <?php
    if (is_array($args['people']) && !empty($args['people'])) :
        foreach ($args['people'] as $post) :
            $args['post'] = $post;
            nvis_prog_get_template_part('archive-person/person-item', $args);
        endforeach;
    else: ?>

    <p class="empty-state-message"><?php echo esc_html($args['label_no_one_found']); ?>
    </p>

    <?php endif; ?>
</section>