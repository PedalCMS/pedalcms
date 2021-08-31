<?php

namespace InvisibleUs\Programs;

use InvisibleUs\Programs\TemplateManager;

add_action('init', __NAMESPACE__ . '\setup_template_manager');
add_filter('body_class', __NAMESPACE__ . '\body_class');

function setup_template_manager() {
    $templates = [
        [
            'name'     => 'single-program',
            'callback' => 'is_singular',
            'args'     => ['nvis_program']
        ],
        [
            'name'     => 'archive-program',
            'callback' => 'is_post_type_archive',
            'args'     => ['nvis_program']
        ],
    ];

    $NVIS_TemplateManager = new TemplateManager($templates);

    add_filter('template_include', [$NVIS_TemplateManager, 'maybeUseTemplate'], PHP_INT_MAX);
}

// TODO: Find out why we wanted career class on programs.
// Add nvis_program CSS class by filter.
function body_class($classes) {
    $nvis_program_class = 'single-nvis_program';

    if (isset($_GET['program_id']) || is_singular('nvis_program') || is_singular('nvis_career')) {
        $classes[$nvis_program_class] = $nvis_program_class;
    }

    return $classes;
}
