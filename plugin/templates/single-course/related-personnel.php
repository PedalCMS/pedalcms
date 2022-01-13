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
    'h_level' => 2,
    'heading' => nvis_prog_get_label('instructors')
];

$args = wp_parse_args($args, $defaults);

$posts = get_field('related_course_personnel', $post);
$h_tag = nvis_get_heading_tag($args['h_level']);

if (!empty($posts)) :
?>
<div class="course-personnel">
    <?php
        echo sprintf('<%s>%s</%s>', $h_tag, esc_html($args['heading']), $h_tag);
        nvis_prog_get_template_part('common/posts-links', compact('posts'));
    ?>
</div>
<?php endif;
