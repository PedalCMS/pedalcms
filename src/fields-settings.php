<?php

return [
	[
		'label'             => __( 'Presentation Mode', 'pedalcms' ),
		'name'              => 'pdl_presentation_mode',
		'type'              => 'radio',
		'description'       => __( 'Choose the amount of design and styling you want applied (CSS). Additional options will be available when Tuxedo Mode is active.', 'pedalcms' ),
		'default'     		=> 'full',
		'layout'            => 'vertical',
		'options'           => [
			'none' => 'Ghost — Don\'t style anything. No CSS will be loaded.',
			'base' => 'Stealth — Only basic styling to handle layout. Blends in with current theme as much as possible.',
			'full' => 'Tuxedo — A more refined and opinionated look. Recommended for most sites.',
		],
	],
	[
		'label'             => __( 'Active Color', 'pedalcms' ),
		'name'              => 'pdl_active_color',
		'type'              => 'color',
		'description'       => __( 'The color to be used for links and buttons.', 'pedalcms' ),
		'default'     		=> '#254fab',
	],
	[
		'label'             => __( 'Button Text Color', 'pedalcms' ),
		'name'              => 'pdl_active_color_text',
		'type'              => 'color',
		'description'       => __( 'The color to be used for text on buttons. Set this if white does not provide enough contrast to your active color.', 'pedalcms' ),
		'required'          => 0,
		'default'     		=> '#ffffff',
	],
	[
		'label'             => __( 'Header Image Size', 'pedalcms' ),
		'name'              => 'pdl_image_size_header',
		'type'              => 'select',
		'options'           => [
			'thumbnail'    => 'thumbnail (150 &times; 150)',
			'medium'       => 'medium (300 &times; 300)',
			'medium_large' => 'medium_large (768 &times; 0)',
			'large'        => 'large (1024 &times; 1024)',
			'1536x1536'    => '1536x1536 (1536 &times; 1536)',
			'2048x2048'    => '2048x2048 (2048 &times; 2048)',
			'custom'       => __( 'Custom', 'pedalcms' )
		],
		'default'           => false,
	],
	[
		'label'             => __( 'Custom Width', 'pedalcms' ),
		'name'              => 'pdl_image_size_header_w',
		'default'           => 450,
		'description' 	    => __( 'Measured in pixels' , 'pedalcms' ),
		'min'               => 0,
		'max'               => '',
		'step'              => '',
		'type'              => 'number',
		'conditional_logic' => [
			[
				[
					'field'    => 'pdl_image_size_header',
					'operator' => '==',
					'value'    => 'custom',
				],
			],
		]
	],
	[
		'label'             => __( 'Custom Height', 'pedalcms' ),
		'name'              => 'pdl_image_size_header_h',
		'type'              => 'number',
		'default'     		=> 336,
		'min'               => 0,
		'description' 	    => __( 'Measured in pixels' , 'pedalcms' ),
		'conditional_logic' => [
			[
				[
					'field'    => 'pdl_image_size_header',
					'operator' => '==',
					'value'    => 'custom',
				],
			],
		],
	],
	[
		'label'               => __( 'Display Breadcrumbs', 'pedalcms' ),
		'name'                => 'pdl_display_breadcrumbs',
		'type'                => 'checkbox',
		'description'        => __( 'Disable this if you have two showing up.', 'pedalcms' ),
		'default'       	  => 1,
		'class'               => 'pdl-fancy-toggle',
	],
	[
		'label'             => __( 'Main Content Wrapper Tag', 'pedalcms' ),
		'name'              => 'pdl_main_content_wrapper_tag',
		'type'              => 'select',
		'description'      => __( 'Switch to "main" to fix accessibility issues with some themes.', 'pedalcms' ),
		'options'           => [
			'div'     => 'div',
			'main'    => 'main',
			'section' => 'section',
		],
		'default'		    => 'div',
	]
];
