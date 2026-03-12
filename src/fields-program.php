<?php
/**
 * CassetteCMF field definitions for the Program (pdl_program) post type.
 *
 * @package PedalCMS
 */

declare( strict_types=1 );

namespace PedalCMS;

defined( 'ABSPATH' ) || exit;

return [
	[
		'type'          => 'metabox',
		'name'          => 'program_info',
		'metabox_id'    => 'pedalcms_program_info',
		'metabox_title' => __( 'Program Info', 'pedalcms' ),
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
						'label'  => __( 'Main', 'pedalcms' ),
						'fields' => [
							[
								'type'         => 'text',
								'name'         => 'program_guid',
								'label'        => __( 'Program GUID', 'pedalcms' ),
								'description'  => __( 'Globally unique identifier used to link program data across systems.', 'pedalcms' ),
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
								'type'       => 'taxonomy',
								'name'       => 'program_type',
								'label'      => __( 'Program Type', 'pedalcms' ),
								'taxonomy'   => 'pdl_program_type',
								'field_type' => 'radio',
								'save_terms' => true,
							],
							[
								'type'       => 'taxonomy',
								'name'       => 'instruction_mode',
								'label'      => __( 'Instruction Mode', 'pedalcms' ),
								'taxonomy'   => 'pdl_instruct_mode',
								'field_type' => 'radio',
								'save_terms' => true,
							],
							[
								'type'    => 'checkbox',
								'name'    => 'prerequisites',
								'label'   => __( 'Prerequisites', 'pedalcms' ),
								'default' => 1,
							],
							[
								'type'  => 'wysiwyg',
								'name'  => 'overview_content',
								'label' => __( 'Overview Content', 'pedalcms' ),
							],
							[
								'type'         => 'url',
								'name'         => 'url_request_info',
								'label'        => __( 'Request Info URL', 'pedalcms' ),
								'description'  => __( 'Overrides the global pattern for this program.', 'pedalcms' ),
							],
							[
								'type'  => 'url',
								'name'  => 'url_apply_now',
								'label' => __( 'Apply Now URL', 'pedalcms' ),
							],
							[
								'type'  => 'url',
								'name'  => 'url_contact_us',
								'label' => __( 'Contact Us URL', 'pedalcms' ),
							],
							[
								'type'    => 'checkbox',
								'name'    => 'show_application_deadlines',
								'label'   => __( 'Show Application Deadlines', 'pedalcms' ),
								'default' => 1,
							],
							[
								'type'         => 'repeater',
								'name'         => 'application_deadlines',
								'label'        => __( 'Application Deadlines', 'pedalcms' ),
								'button_label' => __( 'Add Deadline', 'pedalcms' ),
								'fields'       => [
									[
										'type'     => 'text',
										'name'     => 'label',
										'label'    => __( 'Label', 'pedalcms' ),
										'required' => true,
									],
									[
										'type'  => 'text',
										'name'  => 'info',
										'label' => __( 'Info', 'pedalcms' ),
									],
								],
							],
							[
								'type'      => 'relationship',
								'name'      => 'related_contacts',
								'label'     => __( 'Related Contacts', 'pedalcms' ),
								'post_type' => 'pdl_person',
							],
						],
					],

					// ── Curriculum ──────────────────────────────────────────────
					[
						'label'  => __( 'Curriculum', 'pedalcms' ),
						'fields' => [
							[
								'type'    => 'checkbox',
								'name'    => 'show_curriculum_section',
								'label'   => __( 'Show Curriculum Section', 'pedalcms' ),
								'default' => 1,
							],
							[
								'type'  => 'wysiwyg',
								'name'  => 'curriculum_lead',
								'label' => __( 'Curriculum Lead', 'pedalcms' ),
							],
							[
								'type'         => 'repeater',
								'name'         => 'curriculum_sections',
								'label'        => __( 'Curriculum Sections', 'pedalcms' ),
								'button_label' => __( 'Add Section', 'pedalcms' ),
								'fields'       => [
									[
										'type'  => 'text',
										'name'  => 'section_title',
										'label' => __( 'Section Title', 'pedalcms' ),
									],
									[
										'type'  => 'wysiwyg',
										'name'  => 'section_content',
										'label' => __( 'Section Content', 'pedalcms' ),
									],
									[
										'type'      => 'relationship',
										'name'      => 'section_courses',
										'label'     => __( 'Section Courses', 'pedalcms' ),
										'post_type' => 'pdl_course',
									],
								],
							],
						],
					],

					// ── Careers ─────────────────────────────────────────────────
					[
						'label'  => __( 'Careers', 'pedalcms' ),
						'fields' => [
							[
								'type'    => 'checkbox',
								'name'    => 'show_careers_section',
								'label'   => __( 'Show Careers Section', 'pedalcms' ),
								'default' => 1,
							],
							[
								'type'  => 'wysiwyg',
								'name'  => 'careers_lead',
								'label' => __( 'Careers Lead', 'pedalcms' ),
							],
							[
								'type'      => 'relationship',
								'name'      => 'related_program_careers',
								'label'     => __( 'Related Careers', 'pedalcms' ),
								'post_type' => 'pdl_career',
							],
						],
					],

					// ── Faculty & Staff ──────────────────────────────────────────
					[
						'label'  => __( 'Faculty &amp; Staff', 'pedalcms' ),
						'fields' => [
							[
								'type'    => 'checkbox',
								'name'    => 'show_faculty_staff_section',
								'label'   => __( 'Show Faculty &amp; Staff Section', 'pedalcms' ),
								'default' => 1,
							],
							[
								'type'  => 'wysiwyg',
								'name'  => 'faculty_staff_lead',
								'label' => __( 'Faculty &amp; Staff Lead', 'pedalcms' ),
							],
							[
								'type'    => 'checkbox',
								'name'    => 'faculty_staff_by_category',
								'label'   => __( 'Group by Category', 'pedalcms' ),
								'default' => 1,
							],
							[
								'type'      => 'relationship',
								'name'      => 'related_faculty_staff',
								'label'     => __( 'Related Faculty &amp; Staff', 'pedalcms' ),
								'post_type' => 'pdl_person',
							],
						],
					],

					// ── Cost ────────────────────────────────────────────────────
					[
						'label'  => __( 'Cost', 'pedalcms' ),
						'fields' => [
							[
								'type'    => 'checkbox',
								'name'    => 'show_cost_section',
								'label'   => __( 'Show Cost Section', 'pedalcms' ),
								'default' => 1,
							],
							[
								'type'        => 'text',
								'name'        => 'estimated_cost_label',
								'label'       => __( 'Estimated Cost Label', 'pedalcms' ),
								'placeholder' => __( 'Estimated Cost', 'pedalcms' ),
							],
							[
								'type'  => 'text',
								'name'  => 'estimated_cost',
								'label' => __( 'Estimated Cost', 'pedalcms' ),
							],
							[
								'type'  => 'wysiwyg',
								'name'  => 'cost_content',
								'label' => __( 'Cost Content', 'pedalcms' ),
							],
						],
					],

					// ── Apply ────────────────────────────────────────────────────
					[
						'label'  => __( 'Apply', 'pedalcms' ),
						'fields' => [
							[
								'type'    => 'checkbox',
								'name'    => 'show_apply_section',
								'label'   => __( 'Show Apply Section', 'pedalcms' ),
								'default' => 1,
							],
							[
								'type'  => 'wysiwyg',
								'name'  => 'apply_content',
								'label' => __( 'Apply Content', 'pedalcms' ),
							],
						],
					],

					// ── FAQs ─────────────────────────────────────────────────────
					[
						'label'  => __( 'FAQs', 'pedalcms' ),
						'fields' => [
							[
								'type'    => 'checkbox',
								'name'    => 'show_faqs_section',
								'label'   => __( 'Show FAQs Section', 'pedalcms' ),
								'default' => 1,
							],
							[
								'type'    => 'checkbox',
								'name'    => 'faqs_by_category',
								'label'   => __( 'Group FAQs by Category', 'pedalcms' ),
								'default' => 1,
							],
							[
								'type'  => 'wysiwyg',
								'name'  => 'faqs_lead',
								'label' => __( 'FAQs Lead', 'pedalcms' ),
							],
							[
								'type'         => 'repeater',
								'name'         => 'related_faqs_list',
								'label'        => __( 'FAQ List', 'pedalcms' ),
								'button_label' => __( 'Add FAQ', 'pedalcms' ),
								'fields'       => [
									[
										'type'    => 'radio',
										'name'    => 'faq_type',
										'label'   => __( 'FAQ Type', 'pedalcms' ),
										'options' => [
											'global' => __( 'Global FAQ', 'pedalcms' ),
											'local'  => __( 'Local FAQ', 'pedalcms' ),
										],
										'default' => 'global',
									],
									[
										'type'      => 'relationship',
										'name'      => 'faq_post',
										'label'     => __( 'FAQ Post', 'pedalcms' ),
										'post_type' => 'pdl_faq',
										'multiple'  => false,
									],
									[
										'type'  => 'text',
										'name'  => 'question',
										'label' => __( 'Question', 'pedalcms' ),
									],
									[
										'type'  => 'wysiwyg',
										'name'  => 'answer',
										'label' => __( 'Answer', 'pedalcms' ),
									],
									[
										'type'       => 'taxonomy',
										'name'       => 'faq_category',
										'label'      => __( 'FAQ Category', 'pedalcms' ),
										'taxonomy'   => 'pdl_faq_cat',
										'field_type' => 'select',
									],
								],
							],
						],
					],

					// ── News ─────────────────────────────────────────────────────
					[
						'label'  => __( 'News', 'pedalcms' ),
						'fields' => [
							[
								'type'    => 'checkbox',
								'name'    => 'show_news_section',
								'label'   => __( 'Show News Section', 'pedalcms' ),
								'default' => 1,
							],
							[
								'type'       => 'taxonomy',
								'name'       => 'news_tag',
								'label'      => __( 'News Tag', 'pedalcms' ),
								'taxonomy'   => 'post_tag',
								'field_type' => 'select',
								'all_label'  => __( '— None —', 'pedalcms' ),
							],
							[
								'type'    => 'number',
								'name'    => 'news_num_posts',
								'label'   => __( 'Number of News Posts', 'pedalcms' ),
								'default' => 10,
								'min'     => -1,
							],
							[
								'type'    => 'checkbox',
								'name'    => 'news_show_all_link',
								'label'   => __( 'Show "All News" Link', 'pedalcms' ),
								'default' => 1,
							],
							[
								'type'      => 'relationship',
								'name'      => 'news_featured_posts',
								'label'     => __( 'Featured News Posts', 'pedalcms' ),
								'post_type' => 'post',
								'multiple'  => true,
							],
							[
								'type'  => 'wysiwyg',
								'name'  => 'news_lead',
								'label' => __( 'News Lead', 'pedalcms' ),
							],
						],
					],

				], // end tabs
			],
		],
	],
];
