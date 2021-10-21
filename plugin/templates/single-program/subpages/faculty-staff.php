<?php
/**
 * The template for displaying the Faculty & Staff Program Subpage.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

if (nvis_prog_show_subpage('faculty-staff')) : ?>
<div class="program-faculty-staff-subpage program-subpage">

  <h2 class="section-head">Faculty &amp; Staff</h2>

  <?php nvis_prog_get_template_part('single-program/subpages/lead-content'); ?>

  <div class="program-faculty-staff-list">
    <?php
    $people = get_field('related_faculty_staff');

    if (!empty($people)) :
      $h_level = 3;
      $img_size = 'thumbnail';

      if (get_field('faculty_staff_by_category')):
        // TODO: Skip categorization if there is only one cat?
        $cats = nvis_prog_get_people_by_category($people);
        $h_level = 4;

        foreach ($cats as $cat) :
      ?>
    <div class="person-category">
      <h3 id="<?php echo $cat->slug; ?>"
        class="person-category__title">
        <?php echo $cat->name; ?>
      </h3>
      <div class="person-category__list person-list">
        <?php
          foreach ($cat->people as $post) :
            nvis_prog_get_template_part('archive-person/person-item', compact('post', 'h_level', 'img_size'));
          endforeach;
          ?>
      </div>
    </div>
    <?php
        endforeach;
      else:
    ?>
    <div class="person-list">
      <?php
        foreach ($people as $post) :
          nvis_prog_get_template_part('archive-person/person-item', compact('post', 'h_level'));
        endforeach;
      ?>
    </div>
    <?php
      endif;
    endif;
    ?>
  </div>

</div>
<?php endif;
