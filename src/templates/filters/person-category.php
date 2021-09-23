<div class="nvis-filter-person-category nvis-filters-field">
    <label for="person_cat" class="screen-reader-text">Category</label>
    <?php
    wp_dropdown_categories([
        'taxonomy'          => 'nvis_person_cat',
        'name'              => 'person_cat',
        'selected'          => get_query_var('person_cat'),
        'show_option_none'  => 'Any Category',
        'option_none_value' => '',
        'value_field'       => 'slug',
    ]);
    ?>
</div>