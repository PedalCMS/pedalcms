<?php

return [
	'program_guid' => [
		'name'        => 'program_guid',
		'type'        => 'text',
		'label'       => __( 'Program GUID', 'pedalcms' ),
		'placeholder' => __( 'e.g. 6112773d640f4', 'pedalcms'),
		'pattern'     => '[a-zA-Z0-9]+',
		'description' => __( 'The globally unique identifier for the program. Typically, used campus-wide across systems.', 'pedalcms' )
	],
	'college' => [
		'name'        => 'college',
		'type'        => 'select',
		'label'       => __( 'College', 'pedalcms' ),
		'placeholder'   => __( 'Select college', 'pedalcms' ),
		'multiple' => true,
		'options'  => [
			'us'   => 'Engineering',
			'tax'  => 'Populate with Taxonomy',
		],
	],
	'department' => [
		'name'        => 'department',
		'type'        => 'select',
		'label'       => __( 'Department', 'pedalcms' ),
		'placeholder'   => __( 'Select department', 'pedalcms' ),
		'options'  => [
			0 => __( '(Select college first)', 'pedalcms' ),
		],
	],
	'program_type' => [
		'name'        => 'program_type',
		'type'        => 'radio',
		'label'       => __( 'Program Type', 'pedalcms' ),
		'options'  => [
			1 => __( 'Bachelors', 'pedalcms' ),
			2 => __( 'Populate with taxonomy …', 'pedalcms' ),
		],
	],
	'instruction_mode' => [
		'name'        => 'instruction_mode',
		'type'        => 'radio',
		'label'       => __( 'Instruction Mode', 'pedalcms' ),
		'options'  => [
			1 => __( 'In Person', 'pedalcms' ),
			2 => __( 'Populate with taxonomy …', 'pedalcms' ),
		],
	],
	'prerequisites' => [
		'name'        => 'prerequisites',
		'type'        => 'checkbox',
		'label'       => __( 'Prerequisites', 'pedalcms' ),
		'description' => __( 'This course has prerequisite qualifications.', 'pedalcms'),
		'class'       => 'pdl-fancy-toggle'
	],
	'overview_content' => [
		'name'          => 'overview_content',
		'type'			=> 'wysiwyg',
		'textarea_rows' => 20,
		'label'         => __( 'Overview Content', 'pedalcms' ),
		'placeholder'   => __( 'Enter the overview content...', 'pedalcms' )
	],
	'url_request_info' => [
		'name'        => 'url_request_info',
		'type'        => 'url',
		'label'       => __( 'Request Info URL', 'pedalcms' ),
		'description' => __( 'Overrides the global pattern for Request Info URLs.', 'pedalcms' ),
	],
	'url_apply_now' => [
		'name'        => 'url_apply_now',
		'type'        => 'url',
		'label'       => __( 'Apply Now URL', 'pedalcms' ),
		'description' => __( 'Overrides the global pattern for Apply Now URLs.', 'pedalcms' ),
	],
	'url_contact_us' => [
		'name'        => 'url_contact_us',
		'type'        => 'url',
		'label'       => __( 'Contact Us URL', 'pedalcms' ),
		'description' => __( 'Overrides the global pattern for Contact Us URLs.', 'pedalcms' ),
	]
];
