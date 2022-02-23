<?php
defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'show_subpage'        => nvis_prog_show_subpage('curriculum'),
    'subpage_title'       => nvis_prog_get_label('curriculum'),
    'subpage_content'     => get_field('apply_content', $post),
    'curriculum_sections' => get_field('curriculum_sections', $post)
];

$args = nvis_parse_template_args($args, $defaults, $template);

if ($args['show_subpage']) : ?>

<div <?php nvis_subpage_class(); ?>>
    <h2 class="program-subpage__title"><?php echo esc_html($args['subpage_title']); ?>
    </h2>
    <div class="program-subpage__content">
        <?php
        nvis_prog_get_template_part('single-program/subpages/lead-content');

        if (is_array($args['curriculum_sections'])) :
            foreach ($args['curriculum_sections'] as $section) :
                nvis_prog_get_template_part('single-program/curriculum-section', $section);
            endforeach;
        endif;
        ?>
    </div>
</div>

<?php endif;
