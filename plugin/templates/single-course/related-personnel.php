<?php
/**
 * The template for displaying a list of people who teach a Course.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$posts = get_field('related_course_personnel');

if (!empty($posts)) :
?>
<div class="course-personnel">
    <h2>Taught by</h2>
    <?php nvis_prog_get_template_part('common/posts-links', compact('posts')); ?>
</div>
<?php endif;
