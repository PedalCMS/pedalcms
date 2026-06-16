<?php
/**
 * CassetteCMF field definitions for the Person (pdl_person) post type.
 *
 * @package PedalCMS
 */

declare( strict_types=1 );

namespace PedalCMS;

defined( 'ABSPATH' ) || exit;

$fields = [
	[
		'type'          => 'metabox',
		'name'          => 'person_info',
		'metabox_id'    => 'pedalcms_person_info',
		'metabox_title' => __( 'Person Info', 'pedalcms' ),
		'context'       => 'normal',
		'priority'      => 'default',
		'fields'        => [
			[
				'type'  => 'text',
				'name'  => 'job_title',
				'label' => __( 'Job Title', 'pedalcms' ),
			],
			[
				'type'        => 'text',
				'name'        => 'office_phone',
				'label'       => __( 'Office Phone', 'pedalcms' ),
				'placeholder' => '(919) 555-1001',
			],
			[
				'type'  => 'email',
				'name'  => 'email_address',
				'label' => __( 'Email Address', 'pedalcms' ),
			],
			[
				'type'        => 'text',
				'name'        => 'office',
				'label'       => __( 'Office', 'pedalcms' ),
				'placeholder' => __( 'Main Building, 448C', 'pedalcms' ),
			],
			[
				'type'       => 'taxonomy',
				'name'       => 'person_category',
				'label'      => __( 'Person Category', 'pedalcms' ),
				'taxonomy'   => 'pdl_person_cat',
				'field_type' => 'radio',
				'save_terms' => true,
			],
			[
				'type'       => 'taxonomy',
				'name'       => 'college',
				'label'      => __( 'College', 'pedalcms' ),
				'taxonomy'   => 'pdl_college',
				'field_type' => 'select',
				'save_terms' => true,
			],
			[
				'type'        => 'taxonomy',
				'name'        => 'department',
				'label'       => __( 'Department', 'pedalcms' ),
				'taxonomy'    => 'pdl_department',
				'field_type'  => 'select',
				'save_terms'  => false,
				'placeholder' => __( 'Select department', 'pedalcms' ),
			],
			[
				'type'      => 'relationship',
				'name'      => 'related_person_courses',
				'label'     => __( 'Related Courses', 'pedalcms' ),
				'post_type' => 'pdl_course',
			],
		],
	],
];

return apply_filters( 'pdl/cassette/fields/person', $fields );
