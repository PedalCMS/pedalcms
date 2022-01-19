<?php
/**
 * Displays a variety of meta items, for use in a single Person view.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'link_terms' => false,
];

$args = wp_parse_args($args, $defaults);

?>
<div class="single-person__meta">
    <div class="person-meta__item">
        <?php nvis_prog_get_template_part('blocks/job-title', ['job_title' => $post->job_title]); ?>
    </div>
    <?php
    echo
        nvis_get_the_term_list(
            $post,
            'nvis_department',
            '<div class="person-department person-meta__item">',
            ', ',
            '</div>',
            $args['link_terms']
        );
    ?>
</div>