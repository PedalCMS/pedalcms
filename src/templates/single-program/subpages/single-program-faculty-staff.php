<?php if (nvis_prog_show_subpage('faculty-staff')) : ?>
<div class="program-faculty-staff-subpage program-subpage">

  <h2 class="section-head">Faculty &amp; Staff</h2>

  <?php nvis_prog_get_template_part('single-program-subpage-lead-content'); ?>

  <div class="program-people-list">
    <?php
    $people = get_field('related_faculty_staff');

    if (!empty($people)) :
      if (get_field('faculty_staff_by_category')):
        // TODO: Skip categorization if there is only one cat?
        $cats = nvis_prog_get_people_by_category($people);

        foreach ($cats as $cat) :
      ?>
    <div class="person-category">
      <h3 id="<?php echo $cat->slug; ?>"
        class="person-category__title">
        <?php echo $cat->name; ?>
      </h3>
      <div class="person-category__people">
        <?php
          foreach ($cat->people as $person) :
            nvis_prog_get_template_part('single-program-person-item', compact('person'));
          endforeach;
          ?>
      </div>
    </div>
    <?php
        endforeach;
      else:
        foreach ($people as $person) :
          nvis_prog_get_template_part('single-program-sperson-item', compact('person'));
        endforeach;
      endif;
    endif;
    ?>
  </div>

</div>
<?php endif;
