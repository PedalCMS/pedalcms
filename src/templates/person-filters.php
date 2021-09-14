<form
  action="<?php echo get_post_type_archive_link('nvis_person'); ?>"
  class="person-filters nvis-post-filters">
  <fieldset>
    <legend>Filter</legend>
    <div class="nvis-filters-field">
      <label for="s" class="screen-reader-text">Keyword</label>
      <input type="text" name="s" id="prog_keyword" placeholder="Keyword …"
        value="<?php echo get_query_var('s'); ?>">
    </div>
    <div class="nvis-filters-field">
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
    <div class="nvis-filters-field">
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
  </fieldset>
  <button class="button" type="submit">Search</button>
  <a class="reset-link"
    href="<?php echo get_post_type_archive_link('nvis_person'); ?>">Reset
    Filters</a>
</form>