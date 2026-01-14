<?php

return [
	'show_curriculum_section' => [
		'label'               => __( 'Show Curriculum Page?', 'pedalcms' ),
		'name'                => 'show_curriculum_section',
		'type'                => 'checkbox',
		'instructions'        => '',
		'default'       => true,
		'class' => 'pdl-fancy-toggle'
	],
	'curriculum_lead' => [
		'label'         => _x( 'Lead Content', 'Curriculum', 'pedalcms' ),
		'name'          => 'curriculum_lead',
		'type'          => 'wysiwyg',
		'textarea_rows' => 20,
		'instructions'  => __( 'This content goes before the list of curriculum sections.', 'pedalcms' ),
	]
];
