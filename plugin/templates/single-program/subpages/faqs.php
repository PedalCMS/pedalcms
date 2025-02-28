<?php
/**
 * The template for displaying the FAQ Program Subpage.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = pdl_args_or_global('post', $args);

$defaults = [
    'show_subpage'      => pdl_show_subpage('faqs'),
    'group_by_category' => get_field('faqs_by_category', $post),
    'faqs'              => get_field('related_faqs_list', $post),
];

$args = pdl_parse_template_args($args, $defaults, $template);
$faqs = $args['faqs'];

if ($faqs) {
    $faqs = \PedalCMS\Core\FAQ::normalize_faq_types($faqs, $args['group_by_category']);
}

if ($args['show_subpage']) : ?>
<div <?php pdl_subpage_class(); ?>>
  <h2 class="program-subpage__title"><?php echo esc_html(pdl_subpage_title()); ?></h2>

  <div class="program-subpage__content">

    <?php pdl_get_template_part('single-program/subpages/lead-content'); ?>

    <div class="program-faq-list">
      <?php
      if (!empty($faqs)) :
        if ($args['group_by_category']) :
          foreach ($faqs as $cat) :
      ?>
      <div class="faq-category">
        <h3 id="<?php echo $cat->slug; ?>"
          class="faq-category__title">
          <?php echo $cat->name; ?>
        </h3>
        <div class="faq-category__faqs">
          <?php
            foreach ($cat->faqs as $faq) :
              pdl_get_template_part('single-program/faq-item', compact('faq'));
            endforeach;
            ?>
        </div>
      </div>
      <?php
          endforeach;
        else:
          foreach ($faqs as $faq) :
            pdl_get_template_part('single-program/faq-item', compact('faq'));
          endforeach;
        endif;
      endif;
      ?>
    </div>
  </div>

</div>
<?php endif;
