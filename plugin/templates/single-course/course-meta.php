<?php
/**
 * The template for displaying the single Course page header.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'label_credit'       => nvis_prog_get_label('credit'),
    'label_credits'      => nvis_prog_get_label('credits'),
    'label_offered_in'   => nvis_prog_get_label('offered_in'),
    'link_terms'         => false,
];

$args = nvis_parse_template_args($args, $defaults, $template);

?>
<div class="course-meta">
    <div class="course-credits">
        <?php
            echo (int) $post->credits . ' ';
            echo $post->credits === 1 ?
                esc_html($args['label_credit']) :
                esc_html($args['label_credits']);
        ?>
    </div>

    <?php
    if (taxonomy_exists('nvis_session')) :
        echo nvis_get_the_term_list(
            $post,
            'nvis_session',
            sprintf('<div class="course-terms-offered">%s ', esc_html($args['label_offered_in'])),
            ', ',
            '</div>',
            $args['link_terms']
        );
    endif;
    ?>
</div>
