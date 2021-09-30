<?php

namespace InvisibleUs\Programs;

add_filter('document_title_parts', __NAMESPACE__ . '\document_title_parts', 10, 3);

function document_title_parts(array $title): array {
    $post_types = [
        // TODO: Add these to the objects and reference them.
        Program::POST_TYPE => 'Programs',
        Person::POST_TYPE  => 'Directory',
    ];

    foreach ($post_types as $post_type => $replacement) {
        if (nvis_prog_is_filtered_results($post_type)) {
            // TODO: centralize this text so it can be called here and in breadcrumbs.
            $title['title'] = $replacement . ' Filtered Results';

            break;
        }
    }

    return $title;
}
