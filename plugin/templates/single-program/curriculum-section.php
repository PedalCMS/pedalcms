<?php
/**
 * The template for displaying a single curriculum section, for use on Curriculum subpage.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

?>
<div class="curriculum-section">
    <?php if (isset($data['section_title'])): ?>
    <h3 class="curriculum-section__title"><?php echo esc_html($data['section_title']); ?>
    </h3>
    <?php endif;?>
    <?php if (isset($data['section_content'])): ?>
    <div class="curriculum-section__content">
        <?php echo $data['section_content']; ?>
    </div>
    <?php endif;?>

    <?php
    if (isset($data['section_content'])) :
        nvis_prog_get_template_part('single-program/courses-table', ['courses' => $data['section_courses']]);
    endif;
    ?>
</div>