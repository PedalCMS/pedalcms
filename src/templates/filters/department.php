<div class="nvis-filter-department nvis-filters-field">
    <label for="dept" class="screen-reader-text">Department</label>
    <?php
    wp_dropdown_categories([
        'taxonomy'          => 'nvis_department',
        'name'              => 'dept',
        'selected'          => get_query_var('dept'),
        'show_option_none'  => 'Any Department',
        'option_none_value' => '',
        'value_field'       => 'slug',
    ]);
    ?>
</div>