<?php
/**
 * The template for displaying the Faculty & Staff Program Subpage.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'show_subpage'             => nvis_prog_show_subpage('faculty-staff'),
    'show_contact_info_labels' => true,
    'personnel'                => get_field('related_faculty_staff', $post),
    'group_by_category'        => get_field('faculty_staff_by_category', $post),
    'image_size'               => 'thumbnail'
];

$args = nvis_parse_template_args($args, $defaults, $template);

if ($args['show_subpage']) : ?>
<div <?php nvis_subpage_class(); ?>>
  <h2 class="program-subpage__title"><?php echo esc_html(nvis_prog_subpage_title()); ?></h2>

  <div class="program-subpage__content">

    <?php nvis_prog_get_template_part('single-program/subpages/lead-content'); ?>

    <div class="program-faculty-staff-list">
      <?php
      if (!empty($args['personnel'])) :
        $h_level = 3;

        if ($args['group_by_category']):
          // TODO: Skip categorization if there is only one cat?
          $cats = nvis_prog_get_people_by_category($args['personnel']);
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
            foreach ($cat->people as $person) : $person = get_post($person);
              nvis_prog_get_template_part(
                  'archive-person/person-item',
                  [
                      'post'                     => $person,
                      'h_level'                  => $h_level,
                      'img_size'                 => $args['image_size'],
                      'show_contact_info_labels' => $args['show_contact_info_labels']
                  ]
              );
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
          foreach ($args['personnel'] as $person) :
            nvis_prog_get_template_part(
                'archive-person/person-item',
                [
                    'post'                     => $person,
                    'h_level'                  => $h_level,
                    'img_size'                 => $args['image_size'],
                    'show_contact_info_labels' => $args['show_contact_info_labels']
                ]
            );
          endforeach;
        ?>
      </div>
      <?php
        endif;
      endif;
      ?>
    </div>

  </div>
</div>
<?php endif;
