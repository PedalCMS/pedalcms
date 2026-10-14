<?php

defined( 'ABSPATH' ) || exit;

add_action( 'wp_ajax_pedalcms_get_college_departments', 'pedalcms_ajax_get_college_departments' );

/**
 * Sends the departments of a college supplied via POST.
 *
 * @return void
 */
function pedalcms_ajax_get_college_departments() {
	check_ajax_referer( 'pedalcms_admin_data' );

	$terms = isset( $_POST['college'] ) ?
		\PedalCMS\Core\Department::get_by_college( absint( wp_unslash( $_POST['college'] ) ) ) :
		[];

	wp_send_json( $terms );
}
