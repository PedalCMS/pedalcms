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

return [

	// ── College (pdl_college) ────────────────────────────────────────────────
	'pdl_college' => [
		[
			'type'  => 'upload',
			'name'  => 'featured_image',
			'label' => __( 'Featured Image', 'pedalcms' ),
		],
		[
			'type'  => 'upload',
			'name'  => 'header_background',
			'label' => __( 'Header Background', 'pedalcms' ),
		],
	],

	// ── Department (pdl_department) ──────────────────────────────────────────
	'pdl_department' => [
		[
			'type'       => 'taxonomy',
			'name'       => 'college',
			'label'      => __( 'College', 'pedalcms' ),
			'taxonomy'   => 'pdl_college',
			'field_type' => 'select',
		],
		[
			'type'  => 'upload',
			'name'  => 'featured_image',
			'label' => __( 'Featured Image', 'pedalcms' ),
		],
		[
			'type'  => 'upload',
			'name'  => 'header_background',
			'label' => __( 'Header Background', 'pedalcms' ),
		],
	],

	// ── Program Type (pdl_program_type) ─────────────────────────────────────
	'pdl_program_type' => [
		[
			'type'  => 'upload',
			'name'  => 'featured_image',
			'label' => __( 'Featured Image', 'pedalcms' ),
		],
		[
			'type'  => 'upload',
			'name'  => 'header_background',
			'label' => __( 'Header Background', 'pedalcms' ),
		],
		[
			'type'         => 'repeater',
			'name'         => 'application_deadlines',
			'label'        => __( 'Application Deadlines', 'pedalcms' ),
			'button_label' => __( 'Add Deadline', 'pedalcms' ),
			'fields'       => [
				[
					'type'  => 'text',
					'name'  => 'label',
					'label' => __( 'Label', 'pedalcms' ),
				],
				[
					'type'  => 'text',
					'name'  => 'info',
					'label' => __( 'Info', 'pedalcms' ),
				],
			],
		],
	],

	// ── Person Category (pdl_person_cat) ─────────────────────────────────────
	'pdl_person_cat' => [
		[
			'type'  => 'upload',
			'name'  => 'featured_image',
			'label' => __( 'Featured Image', 'pedalcms' ),
		],
		[
			'type'  => 'upload',
			'name'  => 'header_background',
			'label' => __( 'Header Background', 'pedalcms' ),
		],
	],

];
