<?php
/**
 * The template for displaying the News Program Subpage.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = pdl_args_or_global('post', $args);

$defaults = [
    'show_subpage'    => pdl_show_subpage('news'),
    'subpage_title'   => pdl_get_label('news'),
];

$args = pdl_parse_template_args($args, $defaults, $template);

if ($args['show_subpage']) : ?>

<div <?php pdl_subpage_class(); ?>>
    <h2 class="program-subpage__title"><?php echo esc_html(pdl_subpage_title()); ?></h2>
    
    <div class="program-subpage__content">
        <?php
            pdl_get_template_part('single-program/subpages/lead-content');
            pdl_get_template_part('single-program/related-posts', ['post' => $post, 'context' => $template]);
        ?>
    </div>
</div>

<?php endif;
