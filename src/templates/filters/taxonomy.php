<?php
$tax = isset($data['taxonomy']) ? $data['taxonomy'] : null;
$query_var = isset($data['query_var']) ? $data['query_var'] : null;
$label = isset($data['label']) ? $data['label'] : null;
$short_label = isset($data['short_label']) ? $data['short_label'] : $label;

if ($tax && $query_var && $label) :?>
<div
    class="nvis-filter-<?php echo esc_attr($query_var); ?> nvis-filters-field">
    <label for="<?php echo esc_attr($query_var); ?>"
        class="screen-reader-text"><?php echo esc_html($label); ?></label>
    <?php
    wp_dropdown_categories([
        'taxonomy'          => $tax,
        'name'              => $query_var,
        'selected'          => get_query_var($query_var),
        'show_option_none'  => 'Any ' . $short_label,
        'option_none_value' => '',
        'value_field'       => 'slug',
    ]);
    ?>
</div>
<?php else :?>
<div>Missing data to render <?php echo esc_html($tax); ?> filter.
</div>
<?php endif;
