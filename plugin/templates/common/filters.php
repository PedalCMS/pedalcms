<?php
/**
 * A template for displaying a search and filter form.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 *
 */
defined('ABSPATH') || exit;

$defaults = [
    'break_filters_after' => -1,
    'label_filters'       => 'Filter',
    'label_search'        => 'Search',
    'label_reset_filters' => 'Reset Filters',
    'label_show'          => 'Show',
    'label_hide'          => 'Hide',
    'label_more_filters'  => 'More Filters',
    'label_missing_data'  => 'Missing data to render filters.'
];

$args = wp_parse_args($args, $defaults);

$classes = [
    'nvis-post-filters',
    $args['post_type'] .'-filters',
];

/**
 * Fires before the search filter form is loaded.
 *
 * @since 0.1
 *
 * @param array $args The args passed to the template: a list of filters and the post_type.
 */
do_action('nvis/programs/before_filters_form', $args);


if (!empty($args['filters']) && !empty($args['post_type'])) :
    /**
     * Filters the search filters to be displayed.
     *
     * @since 0.1
     *
     * @param array $filters The list of search filters to display.
     * @param string $post_type The post_type arg passed to the template.
     */
    $filters = apply_filters('nvis/programs/search_filters', $args['filters'], $args['post_type']);
?>
<form
    action="<?php echo get_post_type_archive_link($args['post_type']); ?>"
    class="<?php echo implode(' ', $classes); ?>">
    <fieldset>
        <legend><?php echo esc_html($args['label_filters']); ?>
        </legend>
        <div class="filters">
            <?php

        /**
         * Fires before the search filter fields are loaded.
         *
         * @since 0.1
         *
         * @param array $args The args passed to the template: a list of filters and the post_type.
         */
        do_action('nvis/programs/before_filters_fields', $args);

        foreach ($args['filters'] as $i => $filter):
            if ($i === $args['break_filters_after']):
        ?>
            <input id="more-filters" class="show-hide__trigger" type="checkbox">
            <label for="more-filters" class="show-hide__label"
                data-show-label="<?php echo esc_attr($args['label_show']); ?>"
                data-hide-label="<?php echo esc_attr($args['label_hide']); ?>">
                <?php echo esc_html($args['label_more_filters']); ?>
            </label>
            <div class="more-filters show-hide__content">
                <?php
            endif;

            if (is_array($filter) && count($filter) > 1):
                nvis_prog_get_template_part('filters/' . $filter[0], $filter[1]);
            elseif (is_string($filter)):
                nvis_prog_get_template_part('filters/' . $filter);
            endif;
        endforeach;

        if ($args['break_filters_after'] > $i) {
            echo '</div>';
        }

        /**
         * Fires after the search filter fields are loaded.
         *
         * @since 0.1
         *
         * @param array $args The args passed to the template: a list of filters and the post_type.
         */
        do_action('nvis/programs/after_filters_fields', $args);
        ?>
            </div>
    </fieldset>
    <div class="actions">
        <button class="button" type="submit"><?php echo esc_html($args['label_search']); ?></button>
        <?php if (nvis_is_filtered_results($args['post_type'])): ?>
        <a class="reset-link"
            href="<?php echo get_post_type_archive_link($args['post_type']); ?>"><?php echo esc_html($args['label_reset_filters']); ?></a>
        <?php endif; ?>
    </div>
</form>
<?php
else:
    echo esc_html($args['label_missing_data']);
endif;

/**
 * Fires after the search filter form is loaded.
 *
 * @since 0.1
 *
 * @param array $args The args passed to the template: a list of filters and the post_type.
 */
do_action('nvis/programs/after_filters_form', $args);
