<?php
/**
 * The template for displaying a table of Courses, for use on Curriculum subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'courses'       => null,
    'show_credits'  => true,
    'label_course'  => pdl_get_post_type_label('pdl_course', 'singular_name'),
    'label_credits' => ucfirst(pdl_get_label('credits'))
];

$args = pdl_parse_template_args($args, $defaults, $template);

if (is_array($args['courses'])): ?>
<table class="courses-table">
    <thead class="courses-table__header">
        <th><?php echo esc_html($args['label_course']); ?>
        </th>
        <?php if ($args['show_credits']) : ?>
        <th><?php echo esc_html($args['label_credits']); ?>
        </th>
        <?php endif; ?>
    </thead>
    <tbody class="courses-table__body">
        <?php foreach ($args['courses'] as $post) :?>
        <tr class="courses-table__course">
            <td>
                <a href="<?php the_permalink($post); ?>"><?php echo pdl_get_full_course_title($post); ?></a>
            </td>

            <?php if ($args['show_credits']) : ?>
            <td><?php echo (int) $post->credits; ?>
            </td>
            <?php endif; ?>

        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif;
