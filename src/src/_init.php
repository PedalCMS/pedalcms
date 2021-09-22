<?php

namespace InvisibleUs\Programs;

add_action('init', __NAMESPACE__ . '\setup_plugin');
add_action('plugins_loaded', __NAMESPACE__ . '\setup_subpage_manager');


function setup_plugin(): void {
    new Plugin();
    register_content_model();
    register_custom_blocks();
    setup_template_manager();
}

function register_content_model(): void {
    // Register post types.
    (new Program())->register();
    (new Course())->register();
    (new FAQ())->register();
    (new Person())->register();
    // Register taxonomies.
    (new ProgramType())->register();
    (new College())->register();
    (new DeliveryFormat())->register();
    (new PersonCategory())->register();
    (new Department())->register();
    (new FAQCategory())->register();

    return;
}

function register_custom_blocks(): void {
    if (!Person::is_block_editor_enabled()) {
        return;
    }

    new JobTitleBlock();
    new ContactInfoBlock();

    return;
}

function setup_template_manager(): void {
    $person_template = 'single-person';

    if (!Person::is_block_editor_enabled()) {
        $person_template .= '-classic';
    }

    $templates = [
        [
            'name'     => 'single-program',
            'callback' => 'is_singular',
            'args'     => [Program::post_type]
        ],
        [
            'name'     => 'archive-program',
            'callback' => 'is_post_type_archive',
            'args'     => [Program::post_type]
        ],
        [
            'name'     => 'archive-person',
            'callback' => 'is_post_type_archive',
            'args'     => [Person::post_type]
        ],
        [
            'name'     => $person_template,
            'callback' => 'is_singular',
            'args'     => [Person::post_type]
        ]
    ];

    $NVIS_TemplateManager = new TemplateManager(
        NVIS_PROGRAMS_TEMPLATE_PATH,
        NVIS_PROGRAMS_PLUGIN_NAME,
        $templates
    );

    add_filter('template_include', [$NVIS_TemplateManager, 'maybeUseTemplate'], PHP_INT_MAX);

    return;
}

function setup_subpage_manager(): void {
    $mngr = new ProgramSubpageManager();
    $mngr->init();

    return;
}
