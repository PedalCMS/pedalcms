<?php
/**
 * Displays a dropdown filter for a given taxonomy.
 *
 * An abstract template. Only meant to be referenced by other filter templates.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */


defined('ABSPATH') || exit;

$defaults = [
    'taxonomy'             => null,
    'query_var'            => null,
    'label'                => null,
    'short_label'          => null,
    'none_selected_prefix' => nvis_prog_get_label('none_selected_prefix'),
    'missing_data_text'    => nvis_prog_get_label('missing_filter_data')
];

$args = wp_parse_args($args, $defaults);

$short_label = $args['short_label'] ?? $args['label'];

if ($args['taxonomy'] && $args['query_var'] && $args['label']) : ?>
<div
    class="nvis-filter-<?php echo esc_attr($args['query_var']); ?> nvis-filters-field">
    <label
        for="<?php echo esc_attr($args['query_var']); ?>"
        class="screen-reader-text"><?php echo esc_html($args['label']); ?></label>
    <?php
    wp_dropdown_categories([
        'taxonomy'          => $args['taxonomy'],
        'name'              => $args['query_var'],
        'selected'          => get_query_var($args['query_var']),
        'show_option_none'  => $args['none_selected_prefix'] . $short_label,
        'option_none_value' => '',
        'value_field'       => 'slug',
    ]);
    ?>
</div>
<?php else : ?>
<div>
    <?php echo sprintf($args['missing_data_text'], $args['taxonomy']); ?>
</div>
<?php endif;
