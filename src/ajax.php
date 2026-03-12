<?php

add_action( 'wp_ajax_get_college_departments', 'pdl_ajax_get_college_departments' );

/**
 * Sends the departments of a college supplied via POST.
 *
 * @return void
 */
function pdl_ajax_get_college_departments() {
	check_ajax_referer( 'pdl_admin_data' );

	$terms = isset( $_POST['college'] ) ?
		\PedalCMS\Core\Department::get_by_college( $_POST['college'] ) :
		[];

	wp_send_json( $terms );
}
