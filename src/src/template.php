<?php

namespace InvisibleUs\Programs;

// use InvisibleUs\Programs\TemplateManager;

add_action('init', __NAMESPACE__ . '\setup_template_manager');

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

    $NVIS_TemplateManager = new TemplateManager(
        NVIS_PROGRAMS_TEMPLATE_PATH,
        NVIS_PROGRAMS_PLUGIN_NAME,
        $templates
    );

    add_filter('template_include', [$NVIS_TemplateManager, 'maybeUseTemplate'], PHP_INT_MAX);
}
