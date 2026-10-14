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
		'metabox_title' => __( 'Course Info', 'pedal-cms' ),
		'context'       => 'normal',
		'priority'      => 'default',
		'fields'        => [
			[
				'type'        => 'textarea',
				'name'        => 'short_description',
				'label'       => __( 'Short Description', 'pedal-cms' ),
				'description' => __( 'Brief description of the course, ideally one paragraph or less.', 'pedal-cms' ),
			],
			[
				'type'        => 'text',
				'name'        => 'course_code',
				'label'       => __( 'Course Code', 'pedal-cms' ),
				'placeholder' => 'CS101',
			],
			[
				'type'        => 'number',
				'name'        => 'credits',
				'label'       => __( 'Credits', 'pedal-cms' ),
				'placeholder' => '1',
			],
			[
				'type'  => 'text',
				'name'  => 'course_registration_key',
				'label' => __( 'Course Registration Key', 'pedal-cms' ),
			],
			[
				'type'        => 'url',
				'name'        => 'url_reg_search',
				'label'       => __( 'Registration Search URL', 'pedal-cms' ),
				'description' => __( 'Overrides the global setting for course registration search.', 'pedal-cms' ),
			],
			[
				'type'      => 'relationship',
				'name'      => 'related_course_personnel',
				'label'     => __( 'Related Personnel', 'pedal-cms' ),
				'post_type' => 'pdl_person',
			],
		],
	],
];

return apply_filters( 'pdl/cassette/fields/course', $fields );
