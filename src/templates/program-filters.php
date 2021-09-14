<form
  action="<?php echo get_post_type_archive_link('nvis_program'); ?>"
  class="program-filters nvis-post-filters">
  <fieldset>
    <legend>Filter Programs</legend>
    <div class="nvis-filters-fields">
    </div>
    <div class="nvis-filters-field">
      <label for="s" class="screen-reader-text">Keyword</label>
      <input type="text" name="s" id="prog_keyword" placeholder="Keyword …"
        value="<?php echo get_query_var('s'); ?>">
    </div>
    <div class="nvis-filters-field">
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
    <div class="nvis-filters-field">
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
    <div class="nvis-filters-field">
      <label for="prog_college" class="screen-reader-text">College</label>
      <?php
      wp_dropdown_categories([
          'taxonomy'          => 'nvis_program_college',
          'name'              => 'prog_college',
          'selected'          => get_query_var('prog_college'),
          'show_option_none'  => 'Any College',
          'option_none_value' => '',
          'value_field'       => 'slug'
      ]);
      ?>
    </div>
  </fieldset>
  <button class="button" type="submit">Search</button>
  <a class="reset-link"
    href="<?php echo get_post_type_archive_link('nvis_program'); ?>">Reset
    Filters</a>
</form>