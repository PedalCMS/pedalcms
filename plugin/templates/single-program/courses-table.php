<?php
/**
 * The template for displaying a table of Courses, for use on Curriculum subpage.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'courses'       => null,
    'show_credits'  => true,
    'label_course'  => 'Course',
    'label_credits' => 'Credits'
];

$args = wp_parse_args($args, $defaults);

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
                <?php
                if ($post->course_code) :
                    esc_html_e($post->course_code);
                    echo ' – ';
                endif;

                esc_html_e($post->post_title);
                ?>
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
