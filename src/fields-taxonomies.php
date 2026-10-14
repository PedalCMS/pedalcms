<?php
/**
 * CassetteCMF field definitions for taxonomy terms.
 *
 * Returns a keyed array: [ taxonomy_slug => [ field, ... ] ]
 *
 * @package PedalCMS
 */

declare( strict_types=1 );

namespace PedalCMS;

defined( 'ABSPATH' ) || exit;

$pedalcms_fields = [

	// ── College (pedalcms_college) ────────────────────────────────────────────────
	'pedalcms_college'      => [
		[
			'type'  => 'upload',
			'name'  => 'pedalcms_featured_image',
			'label' => __( 'Featured Image', 'pedal-cms' ),
		],
		[
			'type'  => 'upload',
			'name'  => 'pedalcms_header_background',
			'label' => __( 'Header Background', 'pedal-cms' ),
		],
	],

	// ── Department (pedalcms_department) ──────────────────────────────────────────
	'pedalcms_department'   => [
		[
			'type'       => 'taxonomy',
			'name'       => 'pedalcms_college',
			'label'      => __( 'College', 'pedal-cms' ),
			'taxonomy'   => 'pedalcms_college',
			'field_type' => 'select',
		],
		[
			'type'  => 'upload',
			'name'  => 'pedalcms_featured_image',
			'label' => __( 'Featured Image', 'pedal-cms' ),
		],
		[
			'type'  => 'upload',
			'name'  => 'pedalcms_header_background',
			'label' => __( 'Header Background', 'pedal-cms' ),
		],
	],

	// ── Program Type (pedalcms_program_type) ─────────────────────────────────────
	'pedalcms_program_type' => [
		[
			'type'  => 'upload',
			'name'  => 'pedalcms_featured_image',
			'label' => __( 'Featured Image', 'pedal-cms' ),
		],
		[
			'type'  => 'upload',
			'name'  => 'pedalcms_header_background',
			'label' => __( 'Header Background', 'pedal-cms' ),
		],
		[
			'type'         => 'repeater',
			'name'         => 'pedalcms_application_deadlines',
			'label'        => __( 'Application Deadlines', 'pedal-cms' ),
			'button_label' => __( 'Add Deadline', 'pedal-cms' ),
			'fields'       => [
				[
					'type'  => 'text',
					'name'  => 'label',
					'label' => __( 'Label', 'pedal-cms' ),
				],
				[
					'type'  => 'text',
					'name'  => 'info',
					'label' => __( 'Info', 'pedal-cms' ),
				],
			],
		],
	],

	// ── Person Category (pedalcms_person_cat) ─────────────────────────────────────
	'pedalcms_person_cat'   => [
		[
			'type'  => 'upload',
			'name'  => 'pedalcms_featured_image',
			'label' => __( 'Featured Image', 'pedal-cms' ),
		],
		[
			'type'  => 'upload',
			'name'  => 'pedalcms_header_background',
			'label' => __( 'Header Background', 'pedal-cms' ),
		],
	],

];

return apply_filters( 'pedalcms/cassette/fields/taxonomies', $pedalcms_fields );
