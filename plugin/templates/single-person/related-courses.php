<?php
/**
 * The template for displaying Courses taught by a Person.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$posts = get_field('related_person_courses');

if (!empty($posts)) :
?>
<div class="person-courses">
    <h2>Courses Taught</h2>
    <?php nvis_prog_get_template_part('common/posts-links', compact('posts')); ?>
</div>
<?php endif;
