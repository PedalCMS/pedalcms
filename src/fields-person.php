<?php
/**
 * CassetteCMF field definitions for the Person (pedalcms_person) post type.
 *
 * @package PedalCMS
 */

declare( strict_types=1 );

namespace PedalCMS;

defined( 'ABSPATH' ) || exit;

$pedalcms_fields = [
	[
		'type'          => 'metabox',
		'name'          => 'person_info',
		'metabox_id'    => 'pedalcms_person_info',
		'metabox_title' => __( 'Person Info', 'pedal-cms' ),
		'context'       => 'normal',
		'priority'      => 'default',
		'fields'        => [
			[
				'type'  => 'text',
				'name'  => 'pedalcms_job_title',
				'label' => __( 'Job Title', 'pedal-cms' ),
			],
			[
				'type'        => 'text',
				'name'        => 'pedalcms_office_phone',
				'label'       => __( 'Office Phone', 'pedal-cms' ),
				'placeholder' => '(919) 555-1001',
			],
			[
				'type'  => 'email',
				'name'  => 'pedalcms_email_address',
				'label' => __( 'Email Address', 'pedal-cms' ),
			],
			[
				'type'        => 'text',
				'name'        => 'pedalcms_office',
				'label'       => __( 'Office', 'pedal-cms' ),
				'placeholder' => __( 'Main Building, 448C', 'pedal-cms' ),
			],
			[
				'type'       => 'taxonomy',
				'name'       => 'pedalcms_person_category',
				'label'      => __( 'Person Category', 'pedal-cms' ),
				'taxonomy'   => 'pedalcms_person_cat',
				'field_type' => 'radio',
				'save_terms' => true,
			],
			[
				'type'       => 'taxonomy',
				'name'       => 'pedalcms_college',
				'label'      => __( 'College', 'pedal-cms' ),
				'taxonomy'   => 'pedalcms_college',
				'field_type' => 'select',
				'save_terms' => true,
			],
			[
				'type'        => 'taxonomy',
				'name'        => 'pedalcms_department',
				'label'       => __( 'Department', 'pedal-cms' ),
				'taxonomy'    => 'pedalcms_department',
				'field_type'  => 'select',
				'save_terms'  => false,
				'placeholder' => __( 'Select department', 'pedal-cms' ),
			],
			[
				'type'      => 'relationship',
				'name'      => 'pedalcms_related_person_courses',
				'label'     => __( 'Related Courses', 'pedal-cms' ),
				'post_type' => 'pedalcms_course',
			],
		],
	],
];

return apply_filters( 'pedalcms/cassette/fields/person', $pedalcms_fields );
