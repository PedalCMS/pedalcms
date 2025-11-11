<?php

return [
	'show_faculty_staff_section' => [
		'label'               => __( 'Show Faculty & Staff Page?', 'pedalcms' ),
		'name'                => 'show_faculty_staff_section',
		'type'                => 'checkbox',
		'instructions'        => '',
		'default'       => true,
		'class' => 'pdl-fancy-toggle'
	],
	'faculty_staff_lead' => [
		'label'         => _x( 'Lead Content', 'Faculty & Staff', 'pedalcms' ),
		'name'          => 'faculty_staff_lead',
		'type'          => 'textarea',
		'instructions'  => __( 'This content goes before the list of faculty and staff.', 'pedalcms' ),
	]
];
