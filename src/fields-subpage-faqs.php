<?php

return [
	'show_faqs_section' => [
		'label'               => __( 'Show FAQs Page?', 'pedalcms' ),
		'name'                => 'show_faqs_section',
		'type'                => 'checkbox',
		'instructions'        => '',
		'default'       => true,
		'class' => 'pdl-fancy-toggle'
	],
	'faqs_by_category' => [
		'label'               => __( 'Group FAQs by category?', 'pedalcms' ),
		'name'                => 'faqs_by_category',
		'type'                => 'checkbox',
		'instructions'        => '',
		'default'       => true,
		'class' => 'pdl-fancy-toggle'
	],
	'faqs_lead' => [
		'label'         => _x( 'Lead Content', 'FAQs', 'pedalcms' ),
		'name'          => 'faqs_lead',
		'type'          => 'wysiwyg',
		'textarea_rows' => 20,
		'instructions'  => __( 'This content goes before the list of FAQs.', 'pedalcms' ),
	],
	'questions' => [
		'label' => 'Questions',
		'name'	=> 'questions',
		'type'	=> 'repeater',
		'collapsible'	=> true,
		'button_label' => __('Add Question'),
		'row_label' => __('Question'),
		'fields' => [
			'question_text' => [
				'name'        => 'question_text',
				'type'        => 'text',
				'label'       => __( 'Question Text', 'pedalcms' ),
				'placeholder' => __( 'e.g. How much wood would a woodchuck chuck?', 'pedalcms')
			],
			'question_category' => [
				'name'        => 'question_category',
				'type'        => 'text',
				'label'       => __( 'Category', 'pedalcms' ),
				'placeholder' => __( '', 'pedalcms')
			],
		]
	]
];
