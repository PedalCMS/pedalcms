<?php
/**
 * CassetteCMF field definitions for the Course (pdl_course) post type.
 *
 * @package PedalCMS
 */

declare( strict_types=1 );

namespace PedalCMS;

defined( 'ABSPATH' ) || exit;

$fields = [
	[
		'type'          => 'metabox',
		'name'          => 'course_info',
		'metabox_id'    => 'pedalcms_course_info',
		'metabox_title' => __( 'Course Info', 'pedalcms' ),
		'context'       => 'normal',
		'priority'      => 'default',
		'fields'        => [
			[
				'type'        => 'textarea',
				'name'        => 'short_description',
				'label'       => __( 'Short Description', 'pedalcms' ),
				'description' => __( 'Brief description of the course, ideally one paragraph or less.', 'pedalcms' ),
			],
			[
				'type'        => 'text',
				'name'        => 'course_code',
				'label'       => __( 'Course Code', 'pedalcms' ),
				'placeholder' => 'CS101',
			],
			[
				'type'        => 'number',
				'name'        => 'credits',
				'label'       => __( 'Credits', 'pedalcms' ),
				'placeholder' => '1',
			],
			[
				'type'  => 'text',
				'name'  => 'course_registration_key',
				'label' => __( 'Course Registration Key', 'pedalcms' ),
			],
			[
				'type'        => 'url',
				'name'        => 'url_reg_search',
				'label'       => __( 'Registration Search URL', 'pedalcms' ),
				'description' => __( 'Overrides the global setting for course registration search.', 'pedalcms' ),
			],
			[
				'type'      => 'relationship',
				'name'      => 'related_course_personnel',
				'label'     => __( 'Related Personnel', 'pedalcms' ),
				'post_type' => 'pdl_person',
			],
		],
	],
];

return apply_filters( 'pdl/cassette/fields/course', $fields );
