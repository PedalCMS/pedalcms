<?php
/**
 * The template for displaying Courses taught by a Person.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'posts'                => get_field('related_person_courses'),
    'label_courses_taught' => nvis_prog_get_label('courses_taught')
];

$args = nvis_parse_template_args($args, $defaults, $template);

if (!empty($args['posts'])) :
?>
<div class="person-courses">
    <h2><?php echo esc_html($args['label_courses_taught']); ?>
    </h2>
    <?php nvis_prog_get_template_part('common/posts-links', $args); ?>
</div>
<?php endif;
