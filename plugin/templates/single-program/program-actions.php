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
    'label_permalink' => pdl_get_label('program_details'),
    'actions'         => [
        [
            'label' => pdl_get_label('apply_now_action'),
            'url'   => pdl_get_action_link('apply_now', $post),
            'key'   => 'apply_now'
        ],
        [
            'label' => pdl_get_label('request_info_action'),
            'url'   => pdl_get_action_link('request_info', $post),
            'key'   => 'request_info'
        ]
    ],
    'wrapper_class' => 'program-actions'
];

$args = nvis_parse_template_args($args, $defaults, $template);

if ($args['add_permalink']) {
    $permalink = $args['add_permalink'] === true ? get_permalink($post) : $args['add_permalink'];

    array_unshift(
        $args['actions'],
        [
            'label' => $args['label_permalink'],
            'url'   => $permalink,
            'key'   => 'program_details'
        ]
    );
}

pdl_get_template_part('common/action-list', $args);
