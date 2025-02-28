<?php

$post = pdl_args_or_global('post', $args);

$defaults = [
    'context'         => $template,
    'add_permalink'   => false,
    'label_permalink' => pdl_get_label('course_info'),
    'wrapper_class'   => 'course-actions',
    'actions'         => [],
];

$register_url = pdl_get_course_action_link('reg_search', $post);

if ($register_url) {
    $defaults['actions'][] = [
        'label' => pdl_get_label('register_action'),
        'url'   => $register_url,
        'key' => 'register'
    ];
}

$args = pdl_parse_template_args($args, $defaults, $template);

if ($args['add_permalink']) {
    $permalink = $args['add_permalink'] === true ? get_permalink($post) : $args['add_permalink'];

    array_unshift(
        $args['actions'],
        [
            'label' => $args['label_permalink'],
            'url'   => $permalink,
            'key' => 'course_info'
        ]
    );
}

pdl_get_template_part('common/action-list', $args);
