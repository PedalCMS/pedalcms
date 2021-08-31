<?php if (nvis_prog_show_subpage('faqs')) : ?>
  <div class="program-faqs-subpage program-subpage">

    <h2 class="section-head">FAQs</h2>

    <?php nvis_prog_get_template_part('single-program-subpage-lead-content'); ?>

    <div class="program-faq-list">
    <?php
    $faqs = get_field('related_faqs');

    if (!empty($faqs)) :
      if (get_field('faqs_by_category')):
        // TODO: Skip categorization if there is only one cat?
        $cats = nvis_prog_get_faqs_by_category($faqs);

        foreach ($cats as $cat) :
      ?>
      <div class="faq-category">
        <h3 id="<?php echo $cat->slug; ?>" class="faq-category__title"><?php echo $cat->name; ?></h3>
        <div class="faq-category__faqs">
          <?php
          foreach ($cat->faqs as $faq) :
            nvis_prog_get_template_part('single-program-faq-item', compact('faq'));
          endforeach;
          ?>
        </div>
      </div>
      <?php
        endforeach;
      else:
        foreach ($faqs as $faq) :
          nvis_prog_get_template_part('single-program-faq-item', compact('faq'));
        endforeach;
      endif;
    endif;
    ?>
    </div>

  </div>
<?php endif; ?>
