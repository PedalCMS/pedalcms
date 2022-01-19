<?php
/**
 * The template for displaying a list of people who teach a Course.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'h_level'   => 2,
    'style'     => 'full',
    'heading'   => nvis_prog_get_label('instructors'),
    'personnel' => get_field('related_course_personnel', $post)
];

$args = wp_parse_args($args, $defaults);

$style = in_array($args['style'], ['full','links'], true) ? $args['style'] : $defaults['style'];
$h_tag = nvis_get_heading_tag($args['h_level']);

if (!empty($args['personnel'])) :
?>
<div class="course-personnel">
    <?php
    echo sprintf('<%s>%s</%s>', $h_tag, esc_html($args['heading']), $h_tag);

    if ($style === 'full') :
        nvis_prog_get_template_part(
            'archive-person/person-list',
            [
                'people'            => $args['personnel'],
                'layout'            => 'list',
                'show_contact_info' => false,
                'h_level'           => 3,
                'img_size'          => 'thumbnail'
            ]
        );
    elseif ($style === 'links') :
        nvis_prog_get_template_part('common/posts-links', ['posts' => $args['personnel']]);
    endif;
    ?>
</div>
<?php endif;
