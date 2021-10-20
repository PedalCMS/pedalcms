<?php if (nvis_prog_show_subpage('faqs')) : ?>
<div class="program-faqs-subpage program-subpage">

  <h2 class="section-head">FAQs</h2>

  <?php nvis_prog_get_template_part('single-program/subpages/lead-content'); ?>

  <div class="program-faq-list">
    <?php
    $group_by_cat = get_field('faqs_by_category');
    $faqs = get_field('related_faqs_list');
    $faqs = \InvisibleUs\Programs\FAQ::normalize_faq_types($faqs, $group_by_cat);

    if (!empty($faqs)) :
      if ($group_by_cat):
        // TODO: Skip categorization if there is only one cat?
        foreach ($faqs as $cat) :
    ?>
    <div class="faq-category">
      <h3 id="<?php echo $cat->slug; ?>" class="faq-category__title">
        <?php echo $cat->name; ?>
      </h3>
      <div class="faq-category__faqs">
        <?php
          foreach ($cat->faqs as $faq) :
            nvis_prog_get_template_part('single-program/faq-item', compact('faq'));
          endforeach;
          ?>
      </div>
    </div>
    <?php
        endforeach;
      else:
        foreach ($faqs as $faq) :
          nvis_prog_get_template_part('single-program/faq-item', compact('faq'));
        endforeach;
      endif;
    endif;
    ?>
  </div>

</div>
<?php endif;
