<?php
/**
 * The template for displaying a table of Courses, for use on Curriculum subpage.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$courses = $args['courses'] ?? null;

if (is_array($courses)): ?>
<table class="courses-table">
    <thead class="courses-table__header">
        <th>Course</th>
        <th>Credits</th>
    </thead>
    <tbody class="courses-table__body">
        <?php foreach ($courses as $post) :?>
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
            <td><?php echo (int) $post->credits; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif;
