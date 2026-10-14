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

$fields = [

	// ── College (pdl_college) ────────────────────────────────────────────────
	'pdl_college'      => [
		[
			'type'  => 'upload',
			'name'  => 'featured_image',
			'label' => __( 'Featured Image', 'pedal-cms' ),
		],
		[
			'type'  => 'upload',
			'name'  => 'header_background',
			'label' => __( 'Header Background', 'pedal-cms' ),
		],
	],

	// ── Department (pdl_department) ──────────────────────────────────────────
	'pdl_department'   => [
		[
			'type'       => 'taxonomy',
			'name'       => 'college',
			'label'      => __( 'College', 'pedal-cms' ),
			'taxonomy'   => 'pdl_college',
			'field_type' => 'select',
		],
		[
			'type'  => 'upload',
			'name'  => 'featured_image',
			'label' => __( 'Featured Image', 'pedal-cms' ),
		],
		[
			'type'  => 'upload',
			'name'  => 'header_background',
			'label' => __( 'Header Background', 'pedal-cms' ),
		],
	],

	// ── Program Type (pdl_program_type) ─────────────────────────────────────
	'pdl_program_type' => [
		[
			'type'  => 'upload',
			'name'  => 'featured_image',
			'label' => __( 'Featured Image', 'pedal-cms' ),
		],
		[
			'type'  => 'upload',
			'name'  => 'header_background',
			'label' => __( 'Header Background', 'pedal-cms' ),
		],
		[
			'type'         => 'repeater',
			'name'         => 'application_deadlines',
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

	// ── Person Category (pdl_person_cat) ─────────────────────────────────────
	'pdl_person_cat'   => [
		[
			'type'  => 'upload',
			'name'  => 'featured_image',
			'label' => __( 'Featured Image', 'pedal-cms' ),
		],
		[
			'type'  => 'upload',
			'name'  => 'header_background',
			'label' => __( 'Header Background', 'pedal-cms' ),
		],
	],

];

return apply_filters( 'pdl/cassette/fields/taxonomies', $fields );
