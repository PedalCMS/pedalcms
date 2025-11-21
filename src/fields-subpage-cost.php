<?php

return [
	'show_cost_section' => [
		'label'               => __( 'Show Cost Page?', 'pedalcms' ),
		'name'                => 'show_cost_section',
		'type'                => 'checkbox',
		'description'        => '',
		'default'       => true,
		'class' => 'pdl-fancy-toggle'
	],
	'estimated_cost_label' => [
		'label'        => __( 'Estimated Cost Label', 'pedalcms' ),
		'name'         => 'estimated_cost_label',
		'type'         => 'text',
		'description' => '',
		'placeholder'  => _x( 'Estimated Cost', 'field placeholder', 'pedalcms' ),
	],
	'estimated_cost' => [
		'label'        => _x( 'Estimated Cost', 'field label', 'pedalcms' ),
		'name'         => 'estimated_cost',
		'type'         => 'text',
		'description' => __( 'Leave blank to omit this field.', 'pedalcms' ),
	],
	'cost_content' => [
		'label'         => _x( 'Content', 'Cost', 'pedalcms' ),
		'name'          => 'cost_content',
		'type'          => 'textarea',
		'description'  => ''
	]
];
