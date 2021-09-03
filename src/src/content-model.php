<?php

namespace InvisibleUs\Programs;

add_action('init', __NAMESPACE__ . '\register_content_model');

function register_content_model() {
    // Register post types.
    (new Program())->register();
    (new Course())->register();
    (new FAQ())->register();
    (new Person())->register();
    // Register taxonomies.
    (new ProgramType())->register();
    (new College())->register();
    (new DeliveryFormat())->register();
    (new FAQCategory())->register();
}
