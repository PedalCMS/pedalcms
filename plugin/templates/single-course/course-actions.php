<?php

$post = nvis_args_or_global('post', $args);

$defaults = [
    'context'         => $template,
    'add_permalink'   => false,
    'label_permalink' => nvis_prog_get_label('course_info'),
    'wrapper_class'   => 'course-actions',
    'actions'         => [],
];

$register_url = nvis_prog_get_course_action_link('reg_search', $post);

if ($register_url) {
    $defaults['actions'][] = [
        'label' => nvis_prog_get_label('register'),
        'url'   => $register_url,
        'class' => 'register'
    ];
}

$args = wp_parse_args($args, $defaults);

if ($args['add_permalink']) {
    $permalink = $args['add_permalink'] === true ? get_permalink($post) : $args['add_permalink'];

    array_unshift(
        $args['actions'],
        [
            'label' => $args['label_permalink'],
            'url'   => $permalink,
            'class' => 'course-action-details'
        ]
    );
}

nvis_prog_get_template_part('common/action-list', $args);
