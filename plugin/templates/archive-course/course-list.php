<?php
/**
 * Displays a list of Course items, for use in an archive.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

?>
<section class="course-list article-list">
    <?php
    if (is_array($args['courses']) && !empty($args['courses'])) :
        foreach ($args['courses'] as $post) :
            nvis_prog_get_template_part('archive-course/course-item', compact('post'));
        endforeach;
    else: ?>

    <p class="empty-state-message">No courses were found.</p>

    <?php endif; ?>
</section>