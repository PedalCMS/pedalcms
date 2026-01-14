<?php

return [
	'show_careers_section' => [
		'label'               => __( 'Show Careers Page?', 'pedalcms' ),
		'name'                => 'show_careers_section',
		'type'                => 'checkbox',
		'instructions'        => '',
		'default'       => true,
		'class' => 'pdl-fancy-toggle'
	],
	'careers_lead' => [
		'label'         => _x( 'Lead Content', 'Careers', 'pedalcms' ),
		'name'          => 'careers_lead',
		'type'          => 'wysiwyg',
		'textarea_rows' => 20,
		'instructions'  => __( 'This content goes before the list of careers.', 'pedalcms' ),
	]
];
