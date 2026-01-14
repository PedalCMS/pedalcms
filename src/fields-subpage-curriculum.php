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
	],
	'curriculum_sections' => [
		'label'         => __( 'Curriculum Sections', 'pedalcms' ),
		'name'          => 'curriculum_sections',
		'type'          => 'repeater',
		'instructions'  => __( '', 'pedalcms' ),
		'fields'		=> [
			'title' => [
				'name'        => 'title',
				'type'        => 'text',
				'label'       => __( 'Section Title', 'pedalcms' ),
				'placeholder' => __( 'e.g. Humanities', 'pedalcms'),
				'instructions' => ''
			],
			'content' => [
				'label'         => __( 'Content', 'pedalcms' ),
				'name'          => 'curriculum_section_content',
				'type'          => 'wysiwyg',
				'instructions'  => ''
			],
			'courses'  => [
				'name'		    => 'courses',
				'type'		    => 'text',
				'label'		    => __('Courses', 'pedalcms'),
				'instructions'  => __( 'Choose the courses in this section', 'pedalcms' ),
			],
		]
	]
];
