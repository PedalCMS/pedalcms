<?php
/**
 * CassetteCMF field definitions for the Program (pedalcms_program) post type.
 *
 * @package PedalCMS
 */

declare( strict_types=1 );

namespace PedalCMS;

defined( 'ABSPATH' ) || exit;

$pedalcms_fields = [
	[
		'type'          => 'metabox',
		'name'          => 'program_info',
		'metabox_id'    => 'pedalcms_program_info',
		'metabox_title' => __( 'Program Info', 'pedal-cms' ),
		'context'       => 'normal',
		'priority'      => 'default',
		'fields'        => [
			[
				'type'        => 'tabs',
				'name'        => 'program_tabs',
				'orientation' => 'horizontal',
				'tabs'        => [

					// ── Main ────────────────────────────────────────────────────
					[
						'label'  => __( 'Main', 'pedal-cms' ),
						'fields' => [
							[
								'type'        => 'text',
								'name'        => 'pedalcms_program_guid',
								'label'       => __( 'Program GUID', 'pedal-cms' ),
								'description' => __( 'Globally unique identifier used to link program data across systems.', 'pedal-cms' ),
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
								'type'       => 'taxonomy',
								'name'       => 'pedalcms_program_type',
								'label'      => __( 'Program Type', 'pedal-cms' ),
								'taxonomy'   => 'pedalcms_program_type',
								'field_type' => 'radio',
								'save_terms' => true,
							],
							[
								'type'       => 'taxonomy',
								'name'       => 'pedalcms_instruction_mode',
								'label'      => __( 'Instruction Mode', 'pedal-cms' ),
								'taxonomy'   => 'pedalcms_instruct_mode',
								'field_type' => 'radio',
								'save_terms' => true,
							],
							[
								'type'    => 'checkbox',
								'name'    => 'pedalcms_prerequisites',
								'class'   => 'is-fancy-toggle',
								'label'   => __( 'Prerequisites', 'pedal-cms' ),
								'default' => 1,
							],
							[
								'type'  => 'wysiwyg',
								'name'  => 'pedalcms_overview_content',
								'label' => __( 'Overview Content', 'pedal-cms' ),
							],
							[
								'type'        => 'url',
								'name'        => 'pedalcms_url_request_info',
								'label'       => __( 'Request Info URL', 'pedal-cms' ),
								'description' => __( 'Overrides the global pattern for this program.', 'pedal-cms' ),
							],
							[
								'type'  => 'url',
								'name'  => 'pedalcms_url_apply_now',
								'label' => __( 'Apply Now URL', 'pedal-cms' ),
							],
							[
								'type'  => 'url',
								'name'  => 'pedalcms_url_contact_us',
								'label' => __( 'Contact Us URL', 'pedal-cms' ),
							],
							[
								'type'        => 'checkbox',
								'name'        => 'pedalcms_show_application_deadlines',
								'label'       => __( 'Show Application Deadlines', 'pedal-cms' ),
								'default'     => 1,
								'class'       => 'is-fancy-toggle',
								'conditional' => [ 'pedalcms_application_deadlines' ],
							],
							[
								'type'         => 'repeater',
								'name'         => 'pedalcms_application_deadlines',
								'label'        => __( 'Application Deadlines', 'pedal-cms' ),
								'button_label' => __( 'Add Deadline', 'pedal-cms' ),
								'fields'       => [
									[
										'type'     => 'text',
										'name'     => 'label',
										'label'    => __( 'Label', 'pedal-cms' ),
										'required' => true,
									],
									[
										'type'  => 'text',
										'name'  => 'info',
										'label' => __( 'Info', 'pedal-cms' ),
									],
								],
							],
							[
								'type'      => 'relationship',
								'name'      => 'pedalcms_related_contacts',
								'label'     => __( 'Related Contacts', 'pedal-cms' ),
								'post_type' => 'pedalcms_person',
							],
						],
					],

					// ── Curriculum ──────────────────────────────────────────────
					[
						'label'  => __( 'Curriculum', 'pedal-cms' ),
						'fields' => [
							[
								'type'        => 'checkbox',
								'name'        => 'pedalcms_show_curriculum_section',
								'label'       => __( 'Show Curriculum Section', 'pedal-cms' ),
								'default'     => 1,
								'class'       => 'is-fancy-toggle',
								'conditional' => [ 'pedalcms_curriculum_lead', 'pedalcms_curriculum_sections' ],
							],
							[
								'type'  => 'wysiwyg',
								'name'  => 'pedalcms_curriculum_lead',
								'label' => __( 'Curriculum Lead', 'pedal-cms' ),
							],
							[
								'type'         => 'repeater',
								'name'         => 'pedalcms_curriculum_sections',
								'label'        => __( 'Curriculum Sections', 'pedal-cms' ),
								'button_label' => __( 'Add Section', 'pedal-cms' ),
								'fields'       => [
									[
										'type'  => 'text',
										'name'  => 'section_title',
										'label' => __( 'Section Title', 'pedal-cms' ),
									],
									[
										'type'  => 'wysiwyg',
										'name'  => 'section_content',
										'label' => __( 'Section Content', 'pedal-cms' ),
									],
									[
										'type'      => 'relationship',
										'name'      => 'section_courses',
										'label'     => __( 'Section Courses', 'pedal-cms' ),
										'post_type' => 'pedalcms_course',
									],
								],
							],
						],
					],

					// ── Careers ─────────────────────────────────────────────────
					[
						'label'  => __( 'Careers', 'pedal-cms' ),
						'fields' => [
							[
								'type'        => 'checkbox',
								'name'        => 'pedalcms_show_careers_section',
								'label'       => __( 'Show Careers Section', 'pedal-cms' ),
								'default'     => 1,
								'class'       => 'is-fancy-toggle',
								'conditional' => [ 'pedalcms_careers_lead', 'pedalcms_related_program_careers' ],
							],
							[
								'type'  => 'wysiwyg',
								'name'  => 'pedalcms_careers_lead',
								'label' => __( 'Careers Lead', 'pedal-cms' ),
							],
							[
								'type'      => 'relationship',
								'name'      => 'pedalcms_related_program_careers',
								'label'     => __( 'Related Careers', 'pedal-cms' ),
								'post_type' => 'pedalcms_career',
							],
						],
					],

					// ── Faculty & Staff ──────────────────────────────────────────
					[
						'label'  => __( 'Faculty &amp; Staff', 'pedal-cms' ),
						'fields' => [
							[
								'type'        => 'checkbox',
								'name'        => 'pedalcms_show_faculty_staff_section',
								'label'       => __( 'Show Faculty &amp; Staff Section', 'pedal-cms' ),
								'default'     => 1,
								'class'       => 'is-fancy-toggle',
								'conditional' => [ 'pedalcms_faculty_staff_lead', 'pedalcms_faculty_staff_by_category', 'pedalcms_related_faculty_staff' ],
							],
							[
								'type'  => 'wysiwyg',
								'name'  => 'pedalcms_faculty_staff_lead',
								'label' => __( 'Faculty &amp; Staff Lead', 'pedal-cms' ),
							],
							[
								'type'    => 'checkbox',
								'name'    => 'pedalcms_faculty_staff_by_category',
								'class'   => 'is-fancy-toggle',
								'label'   => __( 'Group by Category', 'pedal-cms' ),
								'default' => 1,
							],
							[
								'type'      => 'relationship',
								'name'      => 'pedalcms_related_faculty_staff',
								'label'     => __( 'Related Faculty &amp; Staff', 'pedal-cms' ),
								'post_type' => 'pedalcms_person',
							],
						],
					],

					// ── Cost ────────────────────────────────────────────────────
					[
						'label'  => __( 'Cost', 'pedal-cms' ),
						'fields' => [
							[
								'type'        => 'checkbox',
								'name'        => 'pedalcms_show_cost_section',
								'label'       => __( 'Show Cost Section', 'pedal-cms' ),
								'default'     => 1,
								'class'       => 'is-fancy-toggle',
								'conditional' => [ 'pedalcms_estimated_cost_label', 'pedalcms_estimated_cost', 'pedalcms_cost_content' ],
							],
							[
								'type'        => 'text',
								'name'        => 'pedalcms_estimated_cost_label',
								'label'       => __( 'Estimated Cost Label', 'pedal-cms' ),
								'placeholder' => __( 'Estimated Cost', 'pedal-cms' ),
							],
							[
								'type'  => 'text',
								'name'  => 'pedalcms_estimated_cost',
								'label' => __( 'Estimated Cost', 'pedal-cms' ),
							],
							[
								'type'  => 'wysiwyg',
								'name'  => 'pedalcms_cost_content',
								'label' => __( 'Cost Content', 'pedal-cms' ),
							],
						],
					],

					// ── Apply ────────────────────────────────────────────────────
					[
						'label'  => __( 'Apply', 'pedal-cms' ),
						'fields' => [
							[
								'type'        => 'checkbox',
								'name'        => 'pedalcms_show_apply_section',
								'label'       => __( 'Show Apply Section', 'pedal-cms' ),
								'default'     => 1,
								'class'       => 'is-fancy-toggle',
								'conditional' => 'pedalcms_apply_content',
							],
							[
								'type'  => 'wysiwyg',
								'name'  => 'pedalcms_apply_content',
								'label' => __( 'Apply Content', 'pedal-cms' ),
							],
						],
					],

					// ── FAQs ─────────────────────────────────────────────────────
					[
						'label'  => __( 'FAQs', 'pedal-cms' ),
						'fields' => [
							[
								'type'        => 'checkbox',
								'name'        => 'pedalcms_show_faqs_section',
								'label'       => __( 'Show FAQs Section', 'pedal-cms' ),
								'default'     => 1,
								'class'       => 'is-fancy-toggle',
								'conditional' => [ 'pedalcms_faqs_by_category', 'pedalcms_faqs_lead', 'pedalcms_related_faqs_list' ],
							],
							[
								'type'    => 'checkbox',
								'name'    => 'pedalcms_faqs_by_category',
								'class'   => 'is-fancy-toggle',
								'label'   => __( 'Group FAQs by Category', 'pedal-cms' ),
								'default' => 1,
							],
							[
								'type'  => 'wysiwyg',
								'name'  => 'pedalcms_faqs_lead',
								'label' => __( 'FAQs Lead', 'pedal-cms' ),
							],
							[
								'type'         => 'repeater',
								'name'         => 'pedalcms_related_faqs_list',
								'label'        => __( 'FAQ List', 'pedal-cms' ),
								'button_label' => __( 'Add FAQ', 'pedal-cms' ),
								'fields'       => [
									[
										'type'    => 'radio',
										'name'    => 'faq_type',
										'label'   => __( 'FAQ Type', 'pedal-cms' ),
										'options' => [
											'global' => __( 'Global FAQ', 'pedal-cms' ),
											'local'  => __( 'Local FAQ', 'pedal-cms' ),
										],
										'default' => 'global',
									],
									[
										'type'      => 'relationship',
										'name'      => 'faq_post',
										'label'     => __( 'FAQ Post', 'pedal-cms' ),
										'post_type' => 'pedalcms_faq',
										'multiple'  => false,
									],
									[
										'type'  => 'text',
										'name'  => 'question',
										'label' => __( 'Question', 'pedal-cms' ),
									],
									[
										'type'  => 'wysiwyg',
										'name'  => 'answer',
										'label' => __( 'Answer', 'pedal-cms' ),
									],
									[
										'type'       => 'taxonomy',
										'name'       => 'faq_category',
										'label'      => __( 'FAQ Category', 'pedal-cms' ),
										'taxonomy'   => 'pedalcms_faq_cat',
										'field_type' => 'select',
									],
								],
							],
						],
					],

					// ── News ─────────────────────────────────────────────────────
					[
						'label'  => __( 'News', 'pedal-cms' ),
						'fields' => [
							[
								'type'        => 'checkbox',
								'name'        => 'pedalcms_show_news_section',
								'label'       => __( 'Show News Section', 'pedal-cms' ),
								'default'     => 1,
								'class'       => 'is-fancy-toggle',
								'conditional' => [ 'pedalcms_news_tag', 'pedalcms_news_num_posts', 'pedalcms_news_show_all_link', 'pedalcms_news_featured_posts', 'pedalcms_news_lead' ],
							],
							[
								'type'       => 'taxonomy',
								'name'       => 'pedalcms_news_tag',
								'label'      => __( 'News Tag', 'pedal-cms' ),
								'taxonomy'   => 'post_tag',
								'field_type' => 'select',
								'all_label'  => __( '— None —', 'pedal-cms' ),
							],
							[
								'type'    => 'number',
								'name'    => 'pedalcms_news_num_posts',
								'label'   => __( 'Number of News Posts', 'pedal-cms' ),
								'default' => 10,
								'min'     => -1,
							],
							[
								'type'    => 'checkbox',
								'name'    => 'pedalcms_news_show_all_link',
								'class'   => 'is-fancy-toggle',
								'label'   => __( 'Show "All News" Link', 'pedal-cms' ),
								'default' => 1,
							],
							[
								'type'      => 'relationship',
								'name'      => 'pedalcms_news_featured_posts',
								'label'     => __( 'Featured News Posts', 'pedal-cms' ),
								'post_type' => 'post',
								'multiple'  => true,
							],
							[
								'type'  => 'wysiwyg',
								'name'  => 'pedalcms_news_lead',
								'label' => __( 'News Lead', 'pedal-cms' ),
							],
						],
					],

				], // end tabs
			],
		],
	],
];

return apply_filters( 'pedalcms/cassette/fields/program', $pedalcms_fields );
