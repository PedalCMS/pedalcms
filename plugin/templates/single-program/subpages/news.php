<?php
/**
 * The template for displaying the News Program Subpage.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'show_subpage'    => nvis_prog_show_subpage('news'),
    'subpage_title'   => nvis_prog_get_label('news'),
];

$args = nvis_parse_template_args($args, $defaults, $template);

if ($args['show_subpage']) : ?>

<div <?php nvis_subpage_class(); ?>>
    <h2 class="program-subpage__title"><?php echo esc_html(nvis_prog_subpage_title()); ?></h2>
    
    <div class="program-subpage__content">
        <?php
            nvis_prog_get_template_part('single-program/subpages/lead-content');
            nvis_prog_get_template_part('single-program/related-posts', ['post' => $post, 'context' => $template]);
        ?>
    </div>
</div>

<?php endif;
