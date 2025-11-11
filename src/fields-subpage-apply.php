<?php

return [
	'show_apply_section' => [
		'label'               => __( 'Show Apply Page?', 'pedalcms' ),
		'name'                => 'show_apply_section',
		'type'                => 'checkbox',
		'instructions'        => '',
		'default'       => true,
		'class' => 'pdl-fancy-toggle'
	],
	'apply_content' => [
		'label'         => _x( 'Content', 'Apply', 'pedalcms' ),
		'name'          => 'apply_content',
		'type'          => 'textarea',
		'instructions'  => ''
	]
];
