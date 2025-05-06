<?php
/**
 * The template for displaying a list of people who teach a Course.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = pdl_args_or_global('post', $args);

$defaults = [
    'h_level'                   => 2,
    'style'                     => 'full',
    'label_instructors' => pdl_get_label('instructors'),
    'personnel'                 => get_field('related_course_personnel', $post)
];

$args = pdl_parse_template_args($args, $defaults, $template);

$style = in_array($args['style'], ['full','links'], true) ? $args['style'] : $defaults['style'];
$h_tag = pdl_get_heading_tag($args['h_level']);

if (!empty($args['personnel'])) :
?>
<div class="course-personnel">
    <?php
    printf('<%s>%s</%s>', $h_tag, esc_html($args['label_instructors']), $h_tag);

    if ($style === 'full') :
        pdl_get_template_part(
            'archive-person/person-list',
            [
                'people'            => $args['personnel'],
                'layout'            => 'list',
                'show_contact_info' => false,
                'h_level'           => 3,
                'img_size'          => 'thumbnail',
                'context'           => $template
            ]
        );
    elseif ($style === 'links') :
        pdl_get_template_part('common/posts-links', ['posts' => $args['personnel']]);
    endif;
    ?>
</div>
<?php endif;
