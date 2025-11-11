<?php

return [
	'show_news_section' => [
		'label'               => __( 'Show FAQs Page?', 'pedalcms' ),
		'name'                => 'show_news_section',
		'type'                => 'checkbox',
		'instructions'        => '',
		'default'       => true,
		'class' => 'pdl-fancy-toggle'
	],
	'news_tag' => [
		'name'        => 'news_tag',
		'type'        => 'select',
		'label'       => __( 'News Tag', 'pedalcms' ),
		'instructions' => __( 'The tag that should associate posts with this program.', 'pedalcms' ),
		'options'  => [
			0 => __( 'Populate with taxonomy', 'pedalcms' ),
		],
	],
	'news_num_posts' => [
		'label'         => __( 'Number of Posts', 'pedalcms' ),
		'name'          => 'news_num_posts',
		'type'          => 'number',
		'instructions'  => __( 'Number of posts to show on this subpage. Set to -1 to show all.', 'pedalcms' ),
		'default' 		=> 10,
		'placeholder'   => '10',
		'min'           => -1,
		'step'          => 1,
	],
	'news_show_all_link' => [
		'label'               => __( 'Show link to all posts?', 'pedalcms' ),
		'name'                => 'news_show_all_link',
		'type'                => 'checkbox',
		'instructions'        => __( 'Link to the tag archive view at the bottom of the list?', 'pedalcms' ),
		'default'       => true,
		'class' => 'pdl-fancy-toggle'
	],
	'news_lead' => [
		'label'         => _x( 'Lead Content', 'FAQs', 'pedalcms' ),
		'name'          => 'news_lead',
		'type'          => 'textarea',
		'instructions'  => __( 'Content to appear at the top of the page, before the posts.', 'pedalcms' ),
	]
];
