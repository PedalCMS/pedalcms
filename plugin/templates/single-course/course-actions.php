<?php

$post = nvis_args_or_global('post', $args);

$defaults = [
    'context' => $template,
    'actions' => [
        [
            'label' => nvis_prog_get_label('register'),
            'url'   => nvis_prog_get_course_action_link('reg_search', $post),
            'class' => 'register'
        ],
    ],
    'wrapper_class' => 'course-actions'
];

$args = wp_parse_args($args, $defaults);

nvis_prog_get_template_part('common/action-list', $args);
