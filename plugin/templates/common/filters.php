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
    'filters_legend'    => 'Filter',
    'button_text'       => 'Search',
    'reset_link_text'   => 'Reset Filters',
    'missing_data_text' => 'Missing data to render filters.'
];

$args = wp_parse_args($args, $defaults);

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
    class="<?php echo $args['post_type']; ?>-filters nvis-post-filters">
    <fieldset>
        <legend><?php echo esc_html($args['filters_legend']); ?>
        </legend>
        <?php

        /**
         * Fires before the search filter fields are loaded.
         *
         * @since 0.1
         *
         * @param array $args The args passed to the template: a list of filters and the post_type.
         */
        do_action('nvis/programs/before_filters_fields', $args);

        foreach ($args['filters'] as $filter):
            nvis_prog_get_template_part('filters/' . $filter);
        endforeach;

        /**
         * Fires after the search filter fields are loaded.
         *
         * @since 0.1
         *
         * @param array $args The args passed to the template: a list of filters and the post_type.
         */
        do_action('nvis/programs/after_filters_fields', $args);
        ?>
    </fieldset>
    <button class="button" type="submit"><?php echo esc_html($args['button_text']); ?></button>
    <?php if (nvis_is_filtered_results($args['post_type'])): ?>
    <a class="reset-link"
        href="<?php echo get_post_type_archive_link($args['post_type']); ?>"><?php echo esc_html($args['reset_link_text']); ?></a>
    <?php endif; ?>
</form>
<?php
else:
    echo esc_html($args['missing_data_text']);
endif;

/**
 * Fires after the search filter form is loaded.
 *
 * @since 0.1
 *
 * @param array $args The args passed to the template: a list of filters and the post_type.
 */
do_action('nvis/programs/after_filters_form', $args);
