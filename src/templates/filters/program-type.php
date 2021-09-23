<div class="nvis-filter-program-type nvis-filters-field">
    <label for="prog_type" class="screen-reader-text">Program Level</label>
    <?php
    wp_dropdown_categories([
        'taxonomy'          => 'nvis_program_type',
        'name'              => 'prog_type',
        'selected'          => get_query_var('prog_type'),
        'show_option_none'  => 'Any Program Type',
        'option_none_value' => '',
        'value_field'       => 'slug',
    ]);
    ?>
</div>