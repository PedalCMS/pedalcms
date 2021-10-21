<?php
/**
 * A template for displaying a search and filter form.
 *
 * A sort of abstract or meta template.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 *
 */
defined('ABSPATH') || exit;

if (!empty($data['filters']) && !empty($data['post_type'])) : ?>
<form
    action="<?php echo get_post_type_archive_link($data['post_type']); ?>"
    class="<?php echo $data['post_type']; ?>-filters nvis-post-filters">
    <fieldset>
        <legend>Filter</legend>
        <?php
        foreach ($data['filters'] as $filter):
            nvis_prog_get_template_part('filters/'.$filter);
        endforeach;
        ?>
    </fieldset>
    <button class="button" type="submit">Search</button>
    <?php if (nvis_prog_is_filtered_results($data['post_type'])): ?>
    <a class="reset-link"
        href="<?php echo get_post_type_archive_link($data['post_type']); ?>">Reset
        Filters</a>
    <?php endif; ?>
</form>
<?php else: ?>
Missing data to render filters.
<?php endif;
