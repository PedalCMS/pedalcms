<?php
defined('ABSPATH') || exit;

$courses = $data['courses'] ?? null;

if (is_array($courses)): ?>
<table class="courses-table">
    <thead class="courses-table__header">
        <th>Course</th>
        <th>Credits</th>
    </thead>
    <tbody class="courses-table__body">
        <?php foreach ($courses as $post) :?>
        <tr class="courses-table__course">
            <td><?php esc_html_e($post->post_title); ?>
            </td>
            <td><?php echo (int) $post->credits; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif;
