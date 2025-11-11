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
		'type'          => 'textarea',
		'instructions'  => __( 'This content goes before the list of FAQs.', 'pedalcms' ),
	]
];
