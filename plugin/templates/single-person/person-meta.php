<?php
/**
 * Displays a variety of meta items, for use in a single Person view.
 *
 * @package PedalCMS
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = pdl_args_or_global('post', $args);

$defaults = [
    'link_terms' => false,
];

$args = pdl_parse_template_args($args, $defaults, $template);

?>
<div class="single-person__meta">
    <div class="person-meta__item">
        <?php pdl_get_template_part('blocks/job-title', ['job_title' => $post->job_title]); ?>
    </div>
    <?php
    if (taxonomy_exists('pdl_department')) :
        echo
            pdl_get_the_term_list(
                $post,
                'pdl_department',
                '<div class="person-department person-meta__item">',
                ', ',
                '</div>',
                $args['link_terms']
            );
    endif;
    ?>
</div>
