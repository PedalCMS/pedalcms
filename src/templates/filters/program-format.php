<div class="nvis-filter-program-format nvis-filters-field">
    <label for="prog_format" class="screen-reader-text">Program Format</label>
    <?php
    wp_dropdown_categories([
        'taxonomy'          => 'nvis_program_format',
        'name'              => 'prog_format',
        'selected'          => get_query_var('prog_format'),
        'show_option_none'  => 'Any Format',
        'option_none_value' => '',
        'value_field'       => 'slug'
    ]);
    ?>
</div>