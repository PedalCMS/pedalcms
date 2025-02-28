<?php 

add_action('wp_ajax_get_college_departments', 'nvis_ajax_get_college_departments' );

function nvis_ajax_get_college_departments() {
    check_ajax_referer('nvis_acf_data');

    $terms = \PedalCMS\Core\Department::get_by_college($_POST['college']);
    
    wp_send_json($terms);
}