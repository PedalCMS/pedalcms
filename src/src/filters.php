<?php

namespace InvisibleUs\Programs;

add_filter('pre_get_document_title', 'pre_get_document_title', 10, 3);

function pre_get_document_title(string $title): string {
    $post_types = [
        // TODO: Add these to the objects and reference them.
        Program::post_type => 'Programs',
        Person::post_type  => 'Directory',
    ];

    foreach ($post_types as $post_type => $title) {
        if (nvis_prog_is_filtered_results($post_type)) {
            // TODO: centralize this text so it can be called here and in breadcrumbs.
            return $title . ' Filtered Results';
        }
    }

    return $title;
}
