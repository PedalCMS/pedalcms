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
    'label_none_selected'  => null,
    'none_selected_prefix' => nvis_prog_get_label('none_selected_prefix'),
    'missing_data_text'    => nvis_prog_get_label('missing_filter_data')
];

$args = nvis_parse_template_args($args, $defaults, $template);

if (!taxonomy_exists($args['taxonomy'])) {
    return;
}

$label = $args['label'] ?? nvis_get_taxonomy_label($args['taxonomy'], 'singular_name');
$short_label = $args['short_label'] ?? $label;
$none_selected = $args['label_none_selected'] ?? 
    nvis_get_taxonomy_label($args['taxonomy'],'none_selected') ??
    $args['none_selected_prefix'] . $short_label;

if ($args['taxonomy'] && $args['query_var'] && $label) : ?>
<div
    class="nvis-filter-<?php echo esc_attr($args['query_var']); ?> nvis-filters-field">
    <label
        for="<?php echo esc_attr($args['query_var']); ?>"
        class="screen-reader-text"><?php echo esc_html($label); ?></label>
    <?php
    wp_dropdown_categories([
        'taxonomy'          => $args['taxonomy'],
        'name'              => $args['query_var'],
        'selected'          => get_query_var($args['query_var']),
        'show_option_none'  => $none_selected,
        'option_none_value' => '',
        'value_field'       => 'slug',
    ]);
    ?>
</div>
<?php else : ?>
<div>
    <?php printf($args['missing_data_text'], $args['taxonomy']); ?>
</div>
<?php endif;
