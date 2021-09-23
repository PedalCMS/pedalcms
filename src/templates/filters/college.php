<div class="nvis-filter-college nvis-filters-field">
    <label for="college" class="screen-reader-text">College</label>
    <?php
    wp_dropdown_categories([
        'taxonomy'          => 'nvis_program_college',
        'name'              => 'college',
        'selected'          => get_query_var('college'),
        'show_option_none'  => 'Any College',
        'option_none_value' => '',
        'value_field'       => 'slug'
    ]);
    ?>
</div>