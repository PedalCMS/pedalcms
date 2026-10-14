<?php
/**
 * CassetteCMF field definitions for the PedalCMS settings page.
 *
 * Returns the field array for six settings tabs, wrapped in a metabox.
 * The metabox forces the CassetteCMF_save_settings handler which saves all
 * nested fields via process_container_fields() — groups, tabs, and all.
 *
 * Naming convention: field names do NOT include the 'pdl_' prefix. CassetteCMF
 * prefixes each option with the page id ('options_pdl'), so field
 * 'presentation_mode' is stored as 'options_pdl_presentation_mode', matching
 * what Plugin::get_option('presentation_mode') reads.
 *
 * @package PedalCMS
 * @since 0.3.0
 */

declare( strict_types=1 );

namespace PedalCMS;

defined( 'ABSPATH' ) || exit;

/**
 * Returns only those search-filter options whose backing taxonomy is active.
 *
 * Non-taxonomy options (e.g. 'keyword') are always included.
 * Taxonomy-backed options are included only when taxonomy_exists() is true.
 *
 * @param array<string,string> $options Raw options map.
 * @return array<string,string>
 */
$active_filter_options = static function ( array $options ): array {
	$tax_map = [
		'program-type'  => 'pdl_program_type',
		'instruct-mode' => 'pdl_instruct_mode',
		'college'       => 'pdl_college',
		'department'    => 'pdl_department',
		'session'       => 'pdl_session',
		'subject'       => 'pdl_subject',
		'person-cat'    => 'pdl_person_cat',
	];
	return array_filter(
		$options,
		static function ( string $key ) use ( $tax_map ): bool {
			return ! isset( $tax_map[ $key ] ) || taxonomy_exists( $tax_map[ $key ] );
		},
		ARRAY_FILTER_USE_KEY
	);
};

$fields = [

	// -------------------------------------------------------------------------
	// Outer wrapper: a metabox containing one tabs field.
	// Having a metabox triggers the CassetteCMF custom save handler so that
	// all nested (tab) fields are persisted through process_container_fields().
	// -------------------------------------------------------------------------
	[
		'type'          => 'metabox',
		'name'          => 'settings_main',
		'metabox_id'    => 'pedalcms_settings_main',
		'metabox_title' => __( 'Settings', 'pedal-cms' ),
		'context'       => 'normal',
		'priority'      => 'default',
		'fields'        => [

			// -----------------------------------------------------------------
			// Tabs field — each tab holds the corresponding section's fields.
			[
				'type'        => 'tabs',
				'name'        => 'settings_tabs',
				'orientation' => 'horizontal',
				'tabs'        => [

					// =========================================================
					// Tab 1: General
					// =========================================================
					[
						'id'     => 'general',
						'label'  => __( 'General', 'pedal-cms' ),
						'icon'   => 'dashicons-admin-generic',
						'fields' => [

							[
								'label'       => __( 'Presentation Mode', 'pedal-cms' ),
								'name'        => 'presentation_mode',
								'type'        => 'radio',
								'description' => __( 'Choose the amount of design and styling you want applied (CSS). Additional options will be available when Tuxedo Mode is active.', 'pedal-cms' ),
								'default'     => 'full',
								'layout'      => 'vertical',
								'options'     => [
									'none' => "Ghost — Don't style anything. No CSS will be loaded.",
									'base' => 'Stealth — Only basic styling to handle layout. Blends in with current theme as much as possible.',
									'full' => 'Tuxedo — A more refined and opinionated look. Recommended for most sites.',
								],
							],

							[
								'label'       => __( 'Active Color', 'pedal-cms' ),
								'name'        => 'active_color',
								'type'        => 'color',
								'description' => __( 'The color to be used for links and buttons.', 'pedal-cms' ),
								'default'     => '#000000',
							],

							[
								'label'       => __( 'Button Text Color', 'pedal-cms' ),
								'name'        => 'active_color_text',
								'type'        => 'color',
								'description' => __( 'The color to be used for text on buttons. Set this if white does not provide enough contrast to your active color.', 'pedal-cms' ),
								'default'     => '#ffffff',
							],

							[
								'label'   => __( 'Header Image Size', 'pedal-cms' ),
								'name'    => 'image_size_header',
								'type'    => 'select',
								'options' => [
									'thumbnail'    => 'thumbnail (150 &times; 150)',
									'medium'       => 'medium (300 &times; 300)',
									'medium_large' => 'medium_large (768 &times; 0)',
									'large'        => 'large (1024 &times; 1024)',
									'1536x1536'    => '1536x1536 (1536 &times; 1536)',
									'2048x2048'    => '2048x2048 (2048 &times; 2048)',
									'custom'       => __( 'Custom', 'pedal-cms' ),
								],
								'default' => 'custom',
							],

							[
								'label'       => __( 'Custom Width', 'pedal-cms' ),
								'name'        => 'image_size_header_w',
								'type'        => 'number',
								'description' => __( 'Measured in pixels', 'pedal-cms' ),
								'default'     => 450,
								'min'         => 0,
								'conditional' => [
									'rules' => [
										[
											'field' => 'image_size_header',
											'value' => 'custom',
										],
									],
								],
							],

							[
								'label'       => __( 'Custom Height', 'pedal-cms' ),
								'name'        => 'image_size_header_h',
								'type'        => 'number',
								'description' => __( 'Measured in pixels', 'pedal-cms' ),
								'default'     => 336,
								'min'         => 0,
								'conditional' => [
									'rules' => [
										[
											'field' => 'image_size_header',
											'value' => 'custom',
										],
									],
								],
							],

							[
								'label'       => __( 'Display Breadcrumbs', 'pedal-cms' ),
								'name'        => 'display_breadcrumbs',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Disable this if you have two showing up.', 'pedal-cms' ),
								'default'     => 1,
							],

							[
								'label'       => __( 'Main Content Wrapper Tag', 'pedal-cms' ),
								'name'        => 'main_content_wrapper_tag',
								'type'        => 'select',
								'description' => __( 'Switch to "main" to fix accessibility issues with some themes.', 'pedal-cms' ),
								'options'     => [
									'div'     => 'div',
									'main'    => 'main',
									'section' => 'section',
								],
								'default'     => 'div',
							],

						], // end general fields
					],

					// =========================================================
					// Tab 2: Programs
					// =========================================================
					[
						'id'     => 'programs',
						'label'  => __( 'Programs', 'pedal-cms' ),
						'icon'   => 'dashicons-welcome-learn-more',
						'fields' => [

							// --- Program Archive ---
							[
								'label'   => __( 'Configure Program Listings', 'pedal-cms' ),
								'name'    => 'program_archive_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Configuration options for searching and browsing the list of programs.</span>',
							],
							[
								'label' => __( 'Page Title', 'pedal-cms' ),
								'name'  => 'program_archive_title',
								'type'  => 'text',
							],

							[
								'label' => __( 'Page Description', 'pedal-cms' ),
								'name'  => 'program_archive_description',
								'type'  => 'wysiwyg',
							],

							[
								'label' => __( 'Featured Image', 'pedal-cms' ),
								'name'  => 'program_archive_featured_image',
								'type'  => 'upload',
							],

							[
								'label'       => __( 'Header Background Image', 'pedal-cms' ),
								'name'        => 'program_archive_header_background',
								'type'        => 'upload',
								'conditional' => [
									'rules' => [
										[
											'field' => 'presentation_mode',
											'value' => 'full',
										],
									],
								],
							],

							[
								'label'       => __( 'Search Filters', 'pedal-cms' ),
								'name'        => 'program_archive_search_filters',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Select the list of search filters you want enabled. Disabled taxonomies will not appear.', 'pedal-cms' ),
								'options'     => $active_filter_options(
									[
										'keyword'       => __( 'Keyword', 'pedal-cms' ),
										'program-type'  => __( 'Program Type', 'pedal-cms' ),
										'instruct-mode' => __( 'Instruction Mode', 'pedal-cms' ),
										'college'       => __( 'College', 'pedal-cms' ),
										'department'    => __( 'Department', 'pedal-cms' ),
									]
								),
								'default'     => [ 'keyword', 'program-type', 'instruct-mode', 'college', 'department' ],
							],

							[
								'label'       => __( 'Show Images in List View', 'pedal-cms' ),
								'name'        => 'program_archive_show_images',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Should lists of programs include their featured images?', 'pedal-cms' ),
								'default'     => 0,
							],

							// --- Individual Program ---
							[
								'label'   => __( 'Configure Programs', 'pedal-cms' ),
								'name'    => 'program_archive_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Configuration options for individual programs.</span>',
							],
							[
								'label' => __( 'Default Program Featured Image', 'pedal-cms' ),
								'name'  => 'program_featured_image',
								'type'  => 'upload',
							],

							[
								'label'        => __( 'Application Deadlines', 'pedal-cms' ),
								'name'         => 'program_application_deadlines',
								'type'         => 'repeater',
								'description'  => __( 'Global application deadlines. Individual programs can override these.', 'pedal-cms' ),
								'button_label' => __( 'Add Deadline', 'pedal-cms' ),
								'fields'       => [
									[
										'label'       => __( 'Deadline Label', 'pedal-cms' ),
										'name'        => 'label',
										'type'        => 'text',
										'placeholder' => _x( 'Fall, Spring, etc.', 'deadline label field placeholder', 'pedal-cms' ),
									],
									[
										'label'       => __( 'Deadline Info', 'pedal-cms' ),
										'name'        => 'info',
										'type'        => 'text',
										'placeholder' => _x( 'e.g. June 24th', 'deadline info field placeholder', 'pedal-cms' ),
									],
								],
							],

							[
								'label'       => __( 'Request Info Button Text', 'pedal-cms' ),
								'name'        => 'program_label_request_info_action',
								'type'        => 'text',
								'placeholder' => __( 'Request Info', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Request Info URL', 'pedal-cms' ),
								'name'        => 'program_url_request_info',
								'type'        => 'url',
								'description' => __( 'Enter a URL pattern. You may use {$program_guid} and {$program_slug}.', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Apply Now Button Text', 'pedal-cms' ),
								'name'        => 'program_label_apply_now_action',
								'type'        => 'text',
								'placeholder' => __( 'Apply Now', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Apply Now URL', 'pedal-cms' ),
								'name'        => 'program_url_apply_now',
								'type'        => 'url',
								'description' => __( 'Enter a URL pattern. You may use {$program_guid} and {$program_slug}.', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Program Contact Label', 'pedal-cms' ),
								'name'        => 'program_label_program_contact',
								'type'        => 'text',
								'placeholder' => __( 'Program Contact', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Contact Button Text', 'pedal-cms' ),
								'name'        => 'program_label_contact_action',
								'type'        => 'text',
								'placeholder' => __( 'Contact', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Contact URL', 'pedal-cms' ),
								'name'        => 'program_url_contact',
								'type'        => 'url',
								'description' => __( 'Enter a URL pattern. You may use {$program_guid} and {$program_slug}.', 'pedal-cms' ),
							],

						], // end programs fields
					],

					// =========================================================
					// Tab 3: Subpages
					// =========================================================
					[
						'id'     => 'subpages',
						'label'  => __( 'Subpages', 'pedal-cms' ),
						'icon'   => 'dashicons-admin-page',
						'fields' => [

							[
								'label'       => __( 'Enabled Program Subpages', 'pedal-cms' ),
								'name'        => 'enable_subpages_pdl_program',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'This enables subpages globally for all programs. Each subpage can also be disabled per-program.', 'pedal-cms' ),
								'options'     => [
									'curriculum'    => __( 'Curriculum', 'pedal-cms' ),
									'careers'       => __( 'Careers', 'pedal-cms' ),
									'faculty-staff' => __( 'Faculty & Staff', 'pedal-cms' ),
									'cost'          => __( 'Cost', 'pedal-cms' ),
									'apply'         => __( 'How to Apply', 'pedal-cms' ),
									'faqs'          => __( 'FAQs', 'pedal-cms' ),
									'news'          => __( 'News', 'pedal-cms' ),
								],
								'default'     => [ 'curriculum', 'careers', 'faculty-staff', 'cost', 'apply', 'faqs', 'news' ],
							],

							// Careers subpage
							[
								'label'   => __( 'Careers', 'pedal-cms' ),
								'name'    => 'career_subpage_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Configuration options for the Careers program subpage.</span>',
							],
							[
								'label'       => __( 'Career Post Type', 'pedal-cms' ),
								'name'        => 'program_subpage_careers_post_type',
								'type'        => 'select',
								'description' => __( 'Select the post type to associate careers with programs.', 'pedal-cms' ),
								'options'     => [
									'pdl_career' => 'pdl_career',
								],
								'default'     => 'pdl_career',
							],

							[
								'label'       => __( 'Page Title', 'pedal-cms' ),
								'name'        => 'program_subpage_careers_title',
								'type'        => 'text',
								'placeholder' => __( 'Careers', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Tab Label', 'pedal-cms' ),
								'name'        => 'program_subpage_careers_tab_label',
								'type'        => 'text',
								'placeholder' => __( 'Careers', 'pedal-cms' ),
							],

							// Curriculum subpage
							[
								'label'   => __( 'Curriculum', 'pedal-cms' ),
								'name'    => 'curriculum_subpage_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Configuration options for the Curriculum program subpage.</span>',
							],
							[
								'label'       => __( 'Page Title', 'pedal-cms' ),
								'name'        => 'program_subpage_curriculum_title',
								'type'        => 'text',
								'placeholder' => __( 'Curriculum', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Tab Label', 'pedal-cms' ),
								'name'        => 'program_subpage_curriculum_tab_label',
								'type'        => 'text',
								'placeholder' => __( 'Curriculum', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Show Credits', 'pedal-cms' ),
								'name'        => 'program_subpage_curriculum_show_credits',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Whether to display the credits column in courses tables.', 'pedal-cms' ),
								'default'     => 1,
							],

							// Faculty & Staff subpage
							[
								'label'   => __( 'Faculty & Staff', 'pedal-cms' ),
								'name'    => 'faculty_staff_subpage_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Configuration options for the Faculty &amp; Staff program subpage.</span>',
							],
							[
								'label'       => __( 'Page Title', 'pedal-cms' ),
								'name'        => 'program_subpage_faculty_staff_title',
								'type'        => 'text',
								'placeholder' => __( 'Faculty & Staff', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Tab Label', 'pedal-cms' ),
								'name'        => 'program_subpage_faculty_staff_tab_label',
								'type'        => 'text',
								'placeholder' => __( 'Faculty & Staff', 'pedal-cms' ),
							],

							// Cost subpage
							[
								'label'   => __( 'Cost', 'pedal-cms' ),
								'name'    => 'cost_subpage_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Configuration options for the Cost program subpage.</span>',
							],
							[
								'label'       => __( 'Page Title', 'pedal-cms' ),
								'name'        => 'program_subpage_cost_title',
								'type'        => 'text',
								'placeholder' => __( 'Cost', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Tab Label', 'pedal-cms' ),
								'name'        => 'program_subpage_cost_tab_label',
								'type'        => 'text',
								'placeholder' => __( 'Cost', 'pedal-cms' ),
							],

							// Apply subpage
							[
								'label'   => __( 'How to Apply', 'pedal-cms' ),
								'name'    => 'apply_subpage_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Configuration options for the How to Apply program subpage.</span>',
							],
							[
								'label'       => __( 'Page Title', 'pedal-cms' ),
								'name'        => 'program_subpage_apply_title',
								'type'        => 'text',
								'placeholder' => __( 'How to Apply', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Tab Label', 'pedal-cms' ),
								'name'        => 'program_subpage_apply_tab_label',
								'type'        => 'text',
								'placeholder' => __( 'How to Apply', 'pedal-cms' ),
							],

							// FAQs subpage
							[
								'label'   => __( 'FAQs', 'pedal-cms' ),
								'name'    => 'faq_subpage_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Configuration options for the FAQs program subpage.</span>',
							],
							[
								'label'       => __( 'Page Title', 'pedal-cms' ),
								'name'        => 'program_subpage_faqs_title',
								'type'        => 'text',
								'placeholder' => __( 'FAQs', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Tab Label', 'pedal-cms' ),
								'name'        => 'program_subpage_faqs_tab_label',
								'type'        => 'text',
								'placeholder' => __( 'FAQs', 'pedal-cms' ),
							],

							// News subpage
							[
								'label'   => __( 'News', 'pedal-cms' ),
								'name'    => 'news_subpage_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Configuration options for the News program subpage.</span>',
							],
							[
								'label'       => __( 'Page Title', 'pedal-cms' ),
								'name'        => 'program_subpage_news_title',
								'type'        => 'text',
								'placeholder' => __( 'News', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Tab Label', 'pedal-cms' ),
								'name'        => 'program_subpage_news_tab_label',
								'type'        => 'text',
								'placeholder' => __( 'News', 'pedal-cms' ),
							],

						], // end subpages fields
					],

					// =========================================================
					// Tab 4: Course Catalog
					// =========================================================
					[
						'id'     => 'course_catalog',
						'label'  => __( 'Course Catalog', 'pedal-cms' ),
						'icon'   => 'dashicons-book',
						'fields' => [

							[
								'label'       => __( 'Enable Course Catalog', 'pedal-cms' ),
								'name'        => 'course_enable',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Activate the Course Catalog post type and archive.', 'pedal-cms' ),
								'default'     => true,
							],

							[
								'label'   => __( 'Configure Course Catalog', 'pedal-cms' ),
								'name'    => 'course_catalog_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Configuration options for searching and browsing the list of courses.</span>',
							],

							[
								'label' => __( 'Page Title', 'pedal-cms' ),
								'name'  => 'course_archive_title',
								'type'  => 'text',
							],

							[
								'label' => __( 'Page Description', 'pedal-cms' ),
								'name'  => 'course_archive_description',
								'type'  => 'wysiwyg',
							],

							[
								'label' => __( 'Featured Image', 'pedal-cms' ),
								'name'  => 'course_archive_featured_image',
								'type'  => 'upload',
							],

							[
								'label'       => __( 'Header Background Image', 'pedal-cms' ),
								'name'        => 'course_archive_header_background',
								'type'        => 'upload',
								'conditional' => [
									'rules' => [
										[
											'field' => 'presentation_mode',
											'value' => 'full',
										],
									],
								],
							],

							[
								'label'       => __( 'Search Filters', 'pedal-cms' ),
								'name'        => 'course_archive_search_filters',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Select the list of search filters you want enabled. Disabled taxonomies will not appear.', 'pedal-cms' ),
								'options'     => $active_filter_options(
									[
										'keyword'       => __( 'Keyword', 'pedal-cms' ),
										'session'       => __( 'Session', 'pedal-cms' ),
										'subject'       => __( 'Subject', 'pedal-cms' ),
										'instruct-mode' => __( 'Instruction Mode', 'pedal-cms' ),
										'college'       => __( 'College', 'pedal-cms' ),
										'department'    => __( 'Department', 'pedal-cms' ),
									]
								),
								'default'     => [ 'keyword', 'session', 'subject', 'instruct-mode', 'college', 'department' ],
							],

							[
								'label'   => __( 'Configure Courses', 'pedal-cms' ),
								'name'    => 'courses_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Configuration options for individual courses.</span>',
							],

							[
								'label'       => __( 'Credits Label (plural)', 'pedal-cms' ),
								'name'        => 'course_label_credits',
								'type'        => 'text',
								'description' => __( 'The unit of measure for course hours. Sometimes called units.', 'pedal-cms' ),
								'placeholder' => __( 'credits', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Credits Label (singular)', 'pedal-cms' ),
								'name'        => 'course_label_credit',
								'type'        => 'text',
								'placeholder' => __( 'credit', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Register Button Text', 'pedal-cms' ),
								'name'        => 'course_label_register_action',
								'type'        => 'text',
								'placeholder' => __( 'Register', 'pedal-cms' ),
							],

							[
								'label' => __( 'Registration Search URL', 'pedal-cms' ),
								'name'  => 'course_url_reg_search',
								'type'  => 'url',
							],

							[
								'label'       => __( 'Instructors Label', 'pedal-cms' ),
								'name'        => 'course_label_instructors',
								'type'        => 'text',
								'placeholder' => __( 'Instructors', 'pedal-cms' ),
							],

						], // end course_catalog fields
					],

					// =========================================================
					// Tab 5: Directory (Personnel / People)
					// =========================================================
					[
						'id'     => 'directory',
						'label'  => __( 'Directory', 'pedal-cms' ),
						'icon'   => 'dashicons-groups',
						'fields' => [

							[
								'label'       => __( 'Enable Faculty & Staff Directory', 'pedal-cms' ),
								'name'        => 'person_enable',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Activate the Personnel post type and archive.', 'pedal-cms' ),
								'default'     => true,
							],

							[
								'label'   => __( 'Configure Directory', 'pedal-cms' ),
								'name'    => 'faculty_staff_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Configuration options for searching and browsing the list of personnel.</span>',
							],

							[
								'label' => __( 'Archive Page Title', 'pedal-cms' ),
								'name'  => 'person_archive_title',
								'type'  => 'text',
							],

							[
								'label' => __( 'Archive Page Description', 'pedal-cms' ),
								'name'  => 'person_archive_description',
								'type'  => 'wysiwyg',
							],

							[
								'label' => __( 'Archive Featured Image', 'pedal-cms' ),
								'name'  => 'person_archive_featured_image',
								'type'  => 'upload',
							],

							[
								'label'       => __( 'Archive Header Background Image', 'pedal-cms' ),
								'name'        => 'person_archive_header_background',
								'type'        => 'upload',
								'conditional' => [
									'rules' => [
										[
											'field' => 'presentation_mode',
											'value' => 'full',
										],
									],
								],
							],

							[
								'label'       => __( 'Archive Search Filters', 'pedal-cms' ),
								'name'        => 'person_archive_search_filters',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Select the list of search filters you want enabled. Disabled taxonomies will not appear.', 'pedal-cms' ),
								'options'     => $active_filter_options(
									[
										'keyword'    => __( 'Keyword', 'pedal-cms' ),
										'person-cat' => __( 'Personnel Category', 'pedal-cms' ),
										'college'    => __( 'College', 'pedal-cms' ),
										'department' => __( 'Department', 'pedal-cms' ),
									]
								),
								'default'     => [ 'keyword', 'person-cat', 'college', 'department' ],
							],

							[
								'label'   => __( 'Configure Personnel', 'pedal-cms' ),
								'name'    => 'personnel_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Configuration options for individual personnel.</span>',
							],

							[
								'label' => __( 'Personnel Header Background Image', 'pedal-cms' ),
								'name'  => 'person_header_background',
								'type'  => 'upload',
							],

							[
								'label'       => __( 'Courses Taught Label', 'pedal-cms' ),
								'name'        => 'person_label_courses_taught',
								'type'        => 'text',
								'placeholder' => __( 'Courses Taught', 'pedal-cms' ),
							],

						], // end directory fields
					],

					// =========================================================
					// Tab 6: Taxonomies
					// =========================================================
					[
						'id'     => 'taxonomies',
						'label'  => __( 'Taxonomies', 'pedal-cms' ),
						'icon'   => 'dashicons-tag',
						'fields' => [

							// --- College ---
							[
								'label'   => __( 'College', 'pedal-cms' ),
								'name'    => 'college_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Used by Programs, Course Catalog, and Faculty & Staff Directory.</span>',
							],

							[
								'label'   => __( 'Enable', 'pedal-cms' ),
								'name'    => 'college_enable',
								'type'    => 'checkbox',
								'class'   => 'is-fancy-toggle',
								'default' => true,
							],

							[
								'label'       => __( 'Enable Archive', 'pedal-cms' ),
								'name'        => 'college_enable_archive',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'If disabled, links will point to a filtered programs view.', 'pedal-cms' ),
								'default'     => true,
							],

							[
								'label'       => __( 'Singular Label', 'pedal-cms' ),
								'name'        => 'college_label_single',
								'type'        => 'text',
								'placeholder' => __( 'College', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Plural Label', 'pedal-cms' ),
								'name'        => 'college_label_plural',
								'type'        => 'text',
								'placeholder' => __( 'Colleges', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Use With', 'pedal-cms' ),
								'name'        => 'college_object_type',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Choose the features to use this taxonomy with.', 'pedal-cms' ),
								'options'     => [
									'pdl_program' => __( 'Programs', 'pedal-cms' ),
									'pdl_course'  => __( 'Course Catalog', 'pedal-cms' ),
									'pdl_person'  => __( 'Faculty & Staff Directory', 'pedal-cms' ),
								],
								'default'     => [ 'pdl_program', 'pdl_course', 'pdl_person' ],
							],

							// --- Department ---
							[
								'label'   => __( 'Department', 'pedal-cms' ),
								'name'    => 'department_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Used by Programs, Course Catalog, and Faculty & Staff Directory.</span>',
							],

							[
								'label'       => __( 'Enable', 'pedal-cms' ),
								'name'        => 'department_enable',
								'type'        => 'conditional_checkbox',
								'class'       => 'is-fancy-toggle',
								'conditional' => [ 'department_enable_archive', 'department_depends_college' ],
								'default'     => true,
							],

							[
								'label'       => __( 'Enable Archive', 'pedal-cms' ),
								'name'        => 'department_enable_archive',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'If disabled, links will point to a filtered programs view.', 'pedal-cms' ),
								'default'     => true,
							],

							[
								'label'       => __( 'Depends on College', 'pedal-cms' ),
								'name'        => 'department_depends_college',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'If enabled, Departments will belong to a College and the relationship will be enforced.', 'pedal-cms' ),
								'default'     => true,
							],

							[
								'label'       => __( 'Singular Label', 'pedal-cms' ),
								'name'        => 'department_label_single',
								'type'        => 'text',
								'placeholder' => __( 'Department', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Plural Label', 'pedal-cms' ),
								'name'        => 'department_label_plural',
								'type'        => 'text',
								'placeholder' => __( 'Departments', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Use With', 'pedal-cms' ),
								'name'        => 'department_object_type',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Choose the features to use this taxonomy with.', 'pedal-cms' ),
								'options'     => [
									'pdl_program' => __( 'Programs', 'pedal-cms' ),
									'pdl_course'  => __( 'Course Catalog', 'pedal-cms' ),
									'pdl_person'  => __( 'Faculty & Staff Directory', 'pedal-cms' ),
								],
								'default'     => [ 'pdl_program', 'pdl_course', 'pdl_person' ],
							],

							// --- Program Type ---
							[
								'label'   => __( 'Program Type', 'pedal-cms' ),
								'name'    => 'program_type_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Used by Programs.</span>',
							],

							[
								'label'   => __( 'Enable', 'pedal-cms' ),
								'name'    => 'program_type_enable',
								'type'    => 'checkbox',
								'class'   => 'is-fancy-toggle',
								'default' => true,
							],

							[
								'label'       => __( 'Enable Archive', 'pedal-cms' ),
								'name'        => 'program_type_enable_archive',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'If disabled, links will point to a filtered programs view.', 'pedal-cms' ),
								'default'     => true,
							],

							[
								'label'       => __( 'Singular Label', 'pedal-cms' ),
								'name'        => 'program_type_label_single',
								'type'        => 'text',
								'placeholder' => __( 'Program Type', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Plural Label', 'pedal-cms' ),
								'name'        => 'program_type_label_plural',
								'type'        => 'text',
								'placeholder' => __( 'Program Types', 'pedal-cms' ),
							],

							// --- Instruction Mode ---
							[
								'label'   => __( 'Instruction Mode', 'pedal-cms' ),
								'name'    => 'instruction_mode_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Used by Programs. (e.g. In-person, Online, Hybrid)</span>',
							],

							[
								'label'   => __( 'Enable', 'pedal-cms' ),
								'name'    => 'instruct_mode_enable',
								'type'    => 'checkbox',
								'class'   => 'is-fancy-toggle',
								'default' => true,
							],

							[
								'label'       => __( 'Singular Label', 'pedal-cms' ),
								'name'        => 'instruct_mode_label_single',
								'type'        => 'text',
								'placeholder' => __( 'Instruction Mode', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Plural Label', 'pedal-cms' ),
								'name'        => 'instruct_mode_label_plural',
								'type'        => 'text',
								'placeholder' => __( 'Instruction Modes', 'pedal-cms' ),
							],

							// --- Subject ---
							[
								'label'   => __( 'Subject', 'pedal-cms' ),
								'name'    => 'subject_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Used in the Course Catalog.</span>',
							],

							[
								'label'   => __( 'Enable', 'pedal-cms' ),
								'name'    => 'subject_enable',
								'type'    => 'checkbox',
								'class'   => 'is-fancy-toggle',
								'default' => true,
							],

							[
								'label'       => __( 'Singular Label', 'pedal-cms' ),
								'name'        => 'subject_label_single',
								'type'        => 'text',
								'placeholder' => __( 'Subject', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Plural Label', 'pedal-cms' ),
								'name'        => 'subject_label_plural',
								'type'        => 'text',
								'placeholder' => __( 'Subjects', 'pedal-cms' ),
							],

							// --- Session ---
							[
								'label'   => __( 'Session', 'pedal-cms' ),
								'name'    => 'session_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Used in the Course Catalog. Also commonly referred to as "term." (e.g. Fall, Spring, Summer)</span>',
							],

							[
								'label'   => __( 'Enable', 'pedal-cms' ),
								'name'    => 'session_enable',
								'type'    => 'checkbox',
								'class'   => 'is-fancy-toggle',
								'default' => true,
							],

							[
								'label'       => __( 'Singular Label', 'pedal-cms' ),
								'name'        => 'session_label_single',
								'type'        => 'text',
								'placeholder' => __( 'Session', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Plural Label', 'pedal-cms' ),
								'name'        => 'session_label_plural',
								'type'        => 'text',
								'placeholder' => __( 'Sessions', 'pedal-cms' ),
							],

							// --- Personnel Category ---
							[
								'label'   => __( 'Personnel Category', 'pedal-cms' ),
								'name'    => 'person_cat_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Used by personnel.</span>',
							],

							[
								'label'   => __( 'Enable', 'pedal-cms' ),
								'name'    => 'person_cat_enable',
								'type'    => 'checkbox',
								'class'   => 'is-fancy-toggle',
								'default' => true,
							],

							[
								'label'       => __( 'Enable Archive', 'pedal-cms' ),
								'name'        => 'person_cat_enable_archive',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'If disabled, links will point to a filtered directory view.', 'pedal-cms' ),
								'default'     => true,
							],

							[
								'label'       => __( 'Singular Label', 'pedal-cms' ),
								'name'        => 'person_cat_label_single',
								'type'        => 'text',
								'placeholder' => __( 'Personnel Category', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Plural Label', 'pedal-cms' ),
								'name'        => 'person_cat_label_plural',
								'type'        => 'text',
								'placeholder' => __( 'Personnel Categories', 'pedal-cms' ),
							],

							// --- FAQ Category ---
							[
								'label'   => __( 'FAQ Category', 'pedal-cms' ),
								'name'    => 'faq_cat_group',
								'type'    => 'custom_html',
								'content' => '<span class="pdl-group-description">Used by programs.</span>',
							],

							[
								'label'       => __( 'Singular Label', 'pedal-cms' ),
								'name'        => 'faq_cat_label_single',
								'type'        => 'text',
								'placeholder' => __( 'FAQ Category', 'pedal-cms' ),
							],

							[
								'label'       => __( 'Plural Label', 'pedal-cms' ),
								'name'        => 'faq_cat_label_plural',
								'type'        => 'text',
								'placeholder' => __( 'FAQ Categories', 'pedal-cms' ),
							],

						], // end taxonomies fields
					],

				], // end tabs
			],

		], // end metabox fields
	],

]; // end fields

return apply_filters( 'pdl/cassette/fields/settings', $fields );
