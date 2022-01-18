<?php
/**
 * The template for displaying Program action buttons.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'context'         => $template,
    'add_permalink'   => false,
    'label_permalink' => nvis_prog_get_label('program_details'),
    'actions'         => [
        [
            'label' => nvis_prog_get_label('apply_now'),
            'url'   => nvis_prog_get_action_link('apply_now', $post),
            'class' => 'apply-now'
        ],
        [
            'label' => nvis_prog_get_label('request_info'),
            'url'   => nvis_prog_get_action_link('request_info', $post),
            'class' => 'request-info'
        ]
    ],
    'wrapper_class' => 'program-actions'
];

$args = wp_parse_args($args, $defaults);

if ($args['add_permalink']) {
    $permalink = $args['add_permalink'] === true ? get_permalink($post) : $args['add_permalink'];

    array_unshift(
        $args['actions'],
        [
            'label' => $args['label_permalink'],
            'url'   => $permalink,
            'class' => 'program-details'
        ]
    );
}

nvis_prog_get_template_part('common/action-list', $args);
