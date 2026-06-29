<?php
/**
 * CassetteCMF field definitions for the PedalCMS settings page.
 *
 * Returns the field array for six settings tabs, wrapped in a metabox.
 * The metabox forces the CassetteCmf_save_settings handler which saves all
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

return [

	// -------------------------------------------------------------------------
	// Outer wrapper: a metabox containing one tabs field.
	// Having a metabox triggers the CassetteCMF custom save handler so that
	// all nested (tab) fields are persisted through process_container_fields().
	// -------------------------------------------------------------------------
	[
		'type'          => 'metabox',
		'name'          => 'settings_main',
		'metabox_id'    => 'pedalcms_settings_main',
		'metabox_title' => __( 'Settings', 'pedalcms' ),
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
						'label'  => __( 'General', 'pedalcms' ),
						'icon'   => 'dashicons-admin-generic',
						'fields' => [

							[
								'label'       => __( 'Presentation Mode', 'pedalcms' ),
								'name'        => 'presentation_mode',
								'type'        => 'radio',
								'description' => __( 'Choose the amount of design and styling you want applied (CSS). Additional options will be available when Tuxedo Mode is active.', 'pedalcms' ),
								'default'     => 'full',
								'layout'      => 'vertical',
								'options'     => [
									'none' => "Ghost — Don't style anything. No CSS will be loaded.",
									'base' => 'Stealth — Only basic styling to handle layout. Blends in with current theme as much as possible.',
									'full' => 'Tuxedo — A more refined and opinionated look. Recommended for most sites.',
								],
							],

							[
								'label'       => __( 'Active Color', 'pedalcms' ),
								'name'        => 'active_color',
								'type'        => 'color',
								'description' => __( 'The color to be used for links and buttons.', 'pedalcms' ),
								'default'     => '#254fab',
							],

							[
								'label'       => __( 'Button Text Color', 'pedalcms' ),
								'name'        => 'active_color_text',
								'type'        => 'color',
								'description' => __( 'The color to be used for text on buttons. Set this if white does not provide enough contrast to your active color.', 'pedalcms' ),
								'default'     => '#ffffff',
							],

							[
								'label'   => __( 'Header Image Size', 'pedalcms' ),
								'name'    => 'image_size_header',
								'type'    => 'select',
								'options' => [
									'thumbnail'    => 'thumbnail (150 &times; 150)',
									'medium'       => 'medium (300 &times; 300)',
									'medium_large' => 'medium_large (768 &times; 0)',
									'large'        => 'large (1024 &times; 1024)',
									'1536x1536'    => '1536x1536 (1536 &times; 1536)',
									'2048x2048'    => '2048x2048 (2048 &times; 2048)',
									'custom'       => __( 'Custom', 'pedalcms' ),
								],
								'default' => null,
							],

							[
								'label'       => __( 'Custom Width', 'pedalcms' ),
								'name'        => 'image_size_header_w',
								'type'        => 'number',
								'description' => __( 'Measured in pixels', 'pedalcms' ),
								'default'     => 450,
								'min'         => 0,
								'conditional' => [
									'rules' => [
										[
											'field' => 'image_size_header',
											'value' => 'custom',
										]
									]
								],
							],

							[
								'label'       => __( 'Custom Height', 'pedalcms' ),
								'name'        => 'image_size_header_h',
								'type'        => 'number',
								'description' => __( 'Measured in pixels', 'pedalcms' ),
								'default'     => 336,
								'min'         => 0,
								'conditional' => [
									'rules' => [
										[
											'field' => 'image_size_header',
											'value' => 'custom',
										]
									]
								],
							],

							[
								'label'       => __( 'Display Breadcrumbs', 'pedalcms' ),
								'name'        => 'display_breadcrumbs',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Disable this if you have two showing up.', 'pedalcms' ),
								'default'     => 1,
							],

							[
								'label'       => __( 'Main Content Wrapper Tag', 'pedalcms' ),
								'name'        => 'main_content_wrapper_tag',
								'type'        => 'select',
								'description' => __( 'Switch to "main" to fix accessibility issues with some themes.', 'pedalcms' ),
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
						'label'  => __( 'Programs', 'pedalcms' ),
						'icon'   => 'dashicons-welcome-learn-more',
						'fields' => [

							// --- Program Archive ---
							[
								'label'       => __( 'Configure Program Listings', 'pedalcms' ),
								'name'        => 'program_archive_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Configuration options for searching and browsing the list of programs.</span>',
							],
							[
								'label' => __( 'Page Title', 'pedalcms' ),
								'name'  => 'program_archive_title',
								'type'  => 'text',
							],

							[
								'label' => __( 'Page Description', 'pedalcms' ),
								'name'  => 'program_archive_description',
								'type'  => 'wysiwyg',
							],

							[
								'label' => __( 'Featured Image', 'pedalcms' ),
								'name'  => 'program_archive_featured_image',
								'type'  => 'upload',
							],

							[
								'label' => __( 'Header Background Image', 'pedalcms' ),
								'name'  => 'program_archive_header_background',
								'type'  => 'upload',
								'conditional' => [
									'rules' => [
										[
											'field' => 'presentation_mode',
											'value' => 'full',
										]
									]
								],
							],

							[
								'label'       => __( 'Search Filters', 'pedalcms' ),
								'name'        => 'program_archive_search_filters',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Select the list of search filters you want enabled. Disabled taxonomies will not appear.', 'pedalcms' ),
								'options'     => $active_filter_options(
									[
										'keyword'       => __( 'Keyword', 'pedalcms' ),
										'program-type'  => __( 'Program Type', 'pedalcms' ),
										'instruct-mode' => __( 'Instruction Mode', 'pedalcms' ),
										'college'       => __( 'College', 'pedalcms' ),
										'department'    => __( 'Department', 'pedalcms' ),
									]
								),
								'default'     => [ 'keyword', 'program-type', 'instruct-mode', 'college', 'department' ],
							],

							[
								'label'       => __( 'Filters Visible', 'pedalcms' ),
								'name'        => 'program_archive_filters_showing',
								'type'        => 'number',
								'description' => __( 'The rest of the filters will be hidden behind a "Show More Filters" toggle. Set to zero to show all.', 'pedalcms' ),
								'default'     => 0,
								'min'         => 0,
							],

							[
								'label'       => __( 'Show Images in List View', 'pedalcms' ),
								'name'        => 'program_archive_show_images',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Should lists of programs include their featured images?', 'pedalcms' ),
								'default'     => 0,
							],

							// --- Individual Program ---
							[
								'label'       => __( 'Configure Programs', 'pedalcms' ),
								'name'        => 'program_archive_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Configuration options for individual programs.</span>',
							],
							[
								'label' => __( 'Default Program Featured Image', 'pedalcms' ),
								'name'  => 'program_featured_image',
								'type'  => 'upload',
							],

							[
								'label'        => __( 'Application Deadlines', 'pedalcms' ),
								'name'         => 'program_application_deadlines',
								'type'         => 'repeater',
								'description'  => __( 'Global application deadlines. Individual programs can override these.', 'pedalcms' ),
								'button_label' => __( 'Add Deadline', 'pedalcms' ),
								'fields'       => [
									[
										'label'       => __( 'Deadline Label', 'pedalcms' ),
										'name'        => 'label',
										'type'        => 'text',
										'placeholder' => _x( 'Fall, Spring, etc.', 'deadline label field placeholder', 'pedalcms' ),
									],
									[
										'label'       => __( 'Deadline Info', 'pedalcms' ),
										'name'        => 'info',
										'type'        => 'text',
										'placeholder' => _x( 'e.g. June 24th', 'deadline info field placeholder', 'pedalcms' ),
									],
								],
							],

							[
								'label'       => __( 'Request Info Button Text', 'pedalcms' ),
								'name'        => 'program_label_request_info_action',
								'type'        => 'text',
								'placeholder' => __( 'Request Info', 'pedalcms' ),
							],

							[
								'label'       => __( 'Request Info URL', 'pedalcms' ),
								'name'        => 'program_url_request_info',
								'type'        => 'url',
								'description' => __( 'Enter a URL pattern. You may use {$program_guid} and {$program_slug}.', 'pedalcms' ),
							],

							[
								'label'       => __( 'Apply Now Button Text', 'pedalcms' ),
								'name'        => 'program_label_apply_now_action',
								'type'        => 'text',
								'placeholder' => __( 'Apply Now', 'pedalcms' ),
							],

							[
								'label'       => __( 'Apply Now URL', 'pedalcms' ),
								'name'        => 'program_url_apply_now',
								'type'        => 'url',
								'description' => __( 'Enter a URL pattern. You may use {$program_guid} and {$program_slug}.', 'pedalcms' ),
							],

							[
								'label'       => __( 'Program Contact Label', 'pedalcms' ),
								'name'        => 'program_label_program_contact',
								'type'        => 'text',
								'placeholder' => __( 'Program Contact', 'pedalcms' ),
							],

							[
								'label'       => __( 'Contact Button Text', 'pedalcms' ),
								'name'        => 'program_label_contact_action',
								'type'        => 'text',
								'placeholder' => __( 'Contact', 'pedalcms' ),
							],

							[
								'label'       => __( 'Contact URL', 'pedalcms' ),
								'name'        => 'program_url_contact',
								'type'        => 'url',
								'description' => __( 'Enter a URL pattern. You may use {$program_guid} and {$program_slug}.', 'pedalcms' ),
							],

						], // end programs fields
					],

					// =========================================================
					// Tab 3: Subpages
					// =========================================================
					[
						'id'     => 'subpages',
						'label'  => __( 'Subpages', 'pedalcms' ),
						'icon'   => 'dashicons-admin-page',
						'fields' => [

							[
								'label'       => __( 'Enabled Program Subpages', 'pedalcms' ),
								'name'        => 'enable_subpages_pdl_program',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'This enables subpages globally for all programs. Each subpage can also be disabled per-program.', 'pedalcms' ),
								'options'     => [
									'curriculum'    => __( 'Curriculum', 'pedalcms' ),
									'careers'       => __( 'Careers', 'pedalcms' ),
									'faculty-staff' => __( 'Faculty & Staff', 'pedalcms' ),
									'cost'          => __( 'Cost', 'pedalcms' ),
									'apply'         => __( 'How to Apply', 'pedalcms' ),
									'faqs'          => __( 'FAQs', 'pedalcms' ),
									'news'          => __( 'News', 'pedalcms' ),
								],
								'default'     => [],
							],

							// Careers subpage
							[
								'label'       => __( 'Careers', 'pedalcms' ),
								'name'        => 'career_subpage_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Configuration options for the Careers program subpage.</span>',
							],
							[
								'label'       => __( 'Career Post Type', 'pedalcms' ),
								'name'        => 'program_subpage_careers_post_type',
								'type'        => 'select',
								'description' => __( 'Select the post type to associate careers with programs.', 'pedalcms' ),
								'options'     => [
									'pdl_career' => 'pdl_career',
								],
								'default'     => 'pdl_career',
							],

							[
								'label'       => __( 'Page Title', 'pedalcms' ),
								'name'        => 'program_subpage_careers_title',
								'type'        => 'text',
								'placeholder' => __( 'Careers', 'pedalcms' ),
							],

							[
								'label'       => __( 'Tab Label', 'pedalcms' ),
								'name'        => 'program_subpage_careers_tab_label',
								'type'        => 'text',
								'placeholder' => __( 'Careers', 'pedalcms' ),
							],

							// Curriculum subpage
							[
								'label'       => __( 'Curriculum', 'pedalcms' ),
								'name'        => 'curriculum_subpage_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Configuration options for the Curriculum program subpage.</span>',
							],
							[
								'label'       => __( 'Page Title', 'pedalcms' ),
								'name'        => 'program_subpage_curriculum_title',
								'type'        => 'text',
								'placeholder' => __( 'Curriculum', 'pedalcms' ),
							],

							[
								'label'       => __( 'Tab Label', 'pedalcms' ),
								'name'        => 'program_subpage_curriculum_tab_label',
								'type'        => 'text',
								'placeholder' => __( 'Curriculum', 'pedalcms' ),
							],

							[
								'label'       => __( 'Show Credits', 'pedalcms' ),
								'name'        => 'program_subpage_curriculum_show_credits',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Whether to display the credits column in courses tables.', 'pedalcms' ),
								'default'     => 1,
							],

							// Faculty & Staff subpage
							[
								'label'       => __( 'Faculty & Staff', 'pedalcms' ),
								'name'        => 'faculty_staff_subpage_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Configuration options for the Faculty &amp; Staff program subpage.</span>',
							],
							[
								'label'       => __( 'Page Title', 'pedalcms' ),
								'name'        => 'program_subpage_faculty_staff_title',
								'type'        => 'text',
								'placeholder' => __( 'Faculty & Staff', 'pedalcms' ),
							],

							[
								'label'       => __( 'Tab Label', 'pedalcms' ),
								'name'        => 'program_subpage_faculty_staff_tab_label',
								'type'        => 'text',
								'placeholder' => __( 'Faculty & Staff', 'pedalcms' ),
							],

							// Cost subpage
							[
								'label'       => __( 'Cost', 'pedalcms' ),
								'name'        => 'cost_subpage_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Configuration options for the Cost program subpage.</span>',
							],
							[
								'label'       => __( 'Page Title', 'pedalcms' ),
								'name'        => 'program_subpage_cost_title',
								'type'        => 'text',
								'placeholder' => __( 'Cost', 'pedalcms' ),
							],

							[
								'label'       => __( 'Tab Label', 'pedalcms' ),
								'name'        => 'program_subpage_cost_tab_label',
								'type'        => 'text',
								'placeholder' => __( 'Cost', 'pedalcms' ),
							],

							// Apply subpage
							[
								'label'       => __( 'How to Apply', 'pedalcms' ),
								'name'        => 'apply_subpage_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Configuration options for the How to Apply program subpage.</span>',
							],
							[
								'label'       => __( 'Page Title', 'pedalcms' ),
								'name'        => 'program_subpage_apply_title',
								'type'        => 'text',
								'placeholder' => __( 'How to Apply', 'pedalcms' ),
							],

							[
								'label'       => __( 'Tab Label', 'pedalcms' ),
								'name'        => 'program_subpage_apply_tab_label',
								'type'        => 'text',
								'placeholder' => __( 'How to Apply', 'pedalcms' ),
							],

							// FAQs subpage
							[
								'label'       => __( 'FAQs', 'pedalcms' ),
								'name'        => 'faq_subpage_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Configuration options for the FAQs program subpage.</span>',
							],
							[
								'label'       => __( 'Page Title', 'pedalcms' ),
								'name'        => 'program_subpage_faqs_title',
								'type'        => 'text',
								'placeholder' => __( 'FAQs', 'pedalcms' ),
							],

							[
								'label'       => __( 'Tab Label', 'pedalcms' ),
								'name'        => 'program_subpage_faqs_tab_label',
								'type'        => 'text',
								'placeholder' => __( 'FAQs', 'pedalcms' ),
							],

							// News subpage
							[
								'label'       => __( 'News', 'pedalcms' ),
								'name'        => 'news_subpage_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Configuration options for the News program subpage.</span>',
							],
							[
								'label'       => __( 'Page Title', 'pedalcms' ),
								'name'        => 'program_subpage_news_title',
								'type'        => 'text',
								'placeholder' => __( 'News', 'pedalcms' ),
							],

							[
								'label'       => __( 'Tab Label', 'pedalcms' ),
								'name'        => 'program_subpage_news_tab_label',
								'type'        => 'text',
								'placeholder' => __( 'News', 'pedalcms' ),
							],

						], // end subpages fields
					],

					// =========================================================
					// Tab 4: Course Catalog
					// =========================================================
					[
						'id'     => 'course_catalog',
						'label'  => __( 'Course Catalog', 'pedalcms' ),
						'icon'   => 'dashicons-book',
						'fields' => [

							[
								'label'       => __( 'Enable Course Catalog', 'pedalcms' ),
								'name'        => 'course_enable',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Activate the Course Catalog post type and archive.', 'pedalcms' ),
								'default'     => 0,
							],

							[
								'label'       => __( 'Configure Course Catalog', 'pedalcms' ),
								'name'        => 'course_catalog_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Configuration options for searching and browsing the list of courses.</span>',
							],

							[
								'label' => __( 'Page Title', 'pedalcms' ),
								'name'  => 'course_archive_title',
								'type'  => 'text',
							],

							[
								'label' => __( 'Page Description', 'pedalcms' ),
								'name'  => 'course_archive_description',
								'type'  => 'wysiwyg',
							],

							[
								'label' => __( 'Featured Image', 'pedalcms' ),
								'name'  => 'course_archive_featured_image',
								'type'  => 'upload',
							],

							[
								'label' => __( 'Header Background Image', 'pedalcms' ),
								'name'  => 'course_archive_header_background',
								'type'  => 'upload',
								'conditional' => [
									'rules' => [
										[
											'field' => 'presentation_mode',
											'value' => 'full',
										]
									]
								],
							],

							[
								'label'       => __( 'Search Filters', 'pedalcms' ),
								'name'        => 'course_archive_search_filters',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Select the list of search filters you want enabled. Disabled taxonomies will not appear.', 'pedalcms' ),
								'options'     => $active_filter_options(
									[
										'keyword'       => __( 'Keyword', 'pedalcms' ),
										'session'       => __( 'Session', 'pedalcms' ),
										'subject'       => __( 'Subject', 'pedalcms' ),
										'instruct-mode' => __( 'Instruction Mode', 'pedalcms' ),
										'college'       => __( 'College', 'pedalcms' ),
										'department'    => __( 'Department', 'pedalcms' ),
									]
								),
								'default'     => [ 'keyword', 'session', 'subject', 'instruct-mode', 'college', 'department' ],
							],

							[
								'label'       => __( 'Filters Visible', 'pedalcms' ),
								'name'        => 'course_archive_filters_showing',
								'type'        => 'number',
								'description' => __( 'Set to zero to show all filters.', 'pedalcms' ),
								'default'     => 3,
								'min'         => 0,
							],

							[
								'label'       => __( 'Configure Courses', 'pedalcms' ),
								'name'        => 'courses_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Configuration options for individual courses.</span>',
							],

							[
								'label'       => __( 'Credits Label (plural)', 'pedalcms' ),
								'name'        => 'course_label_credits',
								'type'        => 'text',
								'description' => __( 'The unit of measure for course hours. Sometimes called units.', 'pedalcms' ),
								'placeholder' => __( 'credits', 'pedalcms' ),
							],

							[
								'label'       => __( 'Credits Label (singular)', 'pedalcms' ),
								'name'        => 'course_label_credit',
								'type'        => 'text',
								'placeholder' => __( 'credit', 'pedalcms' ),
							],

							[
								'label'       => __( 'Register Button Text', 'pedalcms' ),
								'name'        => 'course_label_register_action',
								'type'        => 'text',
								'placeholder' => __( 'Register', 'pedalcms' ),
							],

							[
								'label' => __( 'Registration Search URL', 'pedalcms' ),
								'name'  => 'course_url_reg_search',
								'type'  => 'url',
							],

							[
								'label'       => __( 'Instructors Label', 'pedalcms' ),
								'name'        => 'course_label_instructors',
								'type'        => 'text',
								'placeholder' => __( 'Instructors', 'pedalcms' ),
							],

						], // end course_catalog fields
					],

					// =========================================================
					// Tab 5: Directory (Personnel / People)
					// =========================================================
					[
						'id'     => 'directory',
						'label'  => __( 'Directory', 'pedalcms' ),
						'icon'   => 'dashicons-groups',
						'fields' => [

							[
								'label'       => __( 'Enable Faculty & Staff Directory', 'pedalcms' ),
								'name'        => 'person_enable',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Activate the Personnel post type and archive.', 'pedalcms' ),
								'default'     => 0,
							],

							[
								'label'       => __( 'Configure Directory', 'pedalcms' ),
								'name'        => 'faculty_staff_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Configuration options for searching and browsing the list of personnel.</span>',
							],

							[
								'label' => __( 'Archive Page Title', 'pedalcms' ),
								'name'  => 'person_archive_title',
								'type'  => 'text',
							],

							[
								'label' => __( 'Archive Page Description', 'pedalcms' ),
								'name'  => 'person_archive_description',
								'type'  => 'wysiwyg',
							],

							[
								'label' => __( 'Archive Featured Image', 'pedalcms' ),
								'name'  => 'person_archive_featured_image',
								'type'  => 'upload',
							],

							[
								'label' => __( 'Archive Header Background Image', 'pedalcms' ),
								'name'  => 'person_archive_header_background',
								'type'  => 'upload',
								'conditional' => [
									'rules' => [
										[
											'field' => 'presentation_mode',
											'value' => 'full',
										]
									]
								],
							],

							[
								'label'       => __( 'Archive Search Filters', 'pedalcms' ),
								'name'        => 'person_archive_search_filters',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Select the list of search filters you want enabled. Disabled taxonomies will not appear.', 'pedalcms' ),
								'options'     => $active_filter_options(
									[
										'keyword'    => __( 'Keyword', 'pedalcms' ),
										'person-cat' => __( 'Personnel Category', 'pedalcms' ),
										'college'    => __( 'College', 'pedalcms' ),
										'department' => __( 'Department', 'pedalcms' ),
									]
								),
								'default'     => [ 'keyword', 'person-cat', 'college', 'department' ],
							],

							[
								'label'       => __( 'Archive Filters Visible', 'pedalcms' ),
								'name'        => 'person_archive_filters_showing',
								'type'        => 'number',
								'description' => __( 'Set to zero to show all filters.', 'pedalcms' ),
								'default'     => 2,
								'min'         => 0,
							],

							[
								'label'       => __( 'Configure Personnel', 'pedalcms' ),
								'name'        => 'personnel_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Configuration options for individual personnel.</span>',
							],

							[
								'label' => __( 'Personnel Header Background Image', 'pedalcms' ),
								'name'  => 'person_header_background',
								'type'  => 'upload',
							],

							[
								'label'       => __( 'Courses Taught Label', 'pedalcms' ),
								'name'        => 'person_label_courses_taught',
								'type'        => 'text',
								'placeholder' => __( 'Courses Taught', 'pedalcms' ),
							],

						], // end directory fields
					],

					// =========================================================
					// Tab 6: Taxonomies
					// =========================================================
					[
						'id'     => 'taxonomies',
						'label'  => __( 'Taxonomies', 'pedalcms' ),
						'icon'   => 'dashicons-tag',
						'fields' => [

							// --- College ---
							[
								'label'       => __( 'College', 'pedalcms' ),
								'name'        => 'college_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Used by Programs, Course Catalog, and Faculty & Staff Directory.</span>',
							],

							[
								'label'   => __( 'Enable', 'pedalcms' ),
								'name'    => 'college_enable',
								'type'    => 'checkbox',
								'class'   => 'is-fancy-toggle',
								'default' => 1,
							],

							[
								'label'       => __( 'Enable Archive', 'pedalcms' ),
								'name'        => 'college_enable_archive',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'If disabled, links will point to a filtered programs view.', 'pedalcms' ),
								'default'     => 1,
							],

							[
								'label'       => __( 'Singular Label', 'pedalcms' ),
								'name'        => 'college_label_single',
								'type'        => 'text',
								'placeholder' => __( 'College', 'pedalcms' ),
							],

							[
								'label'       => __( 'Plural Label', 'pedalcms' ),
								'name'        => 'college_label_plural',
								'type'        => 'text',
								'placeholder' => __( 'Colleges', 'pedalcms' ),
							],

							[
								'label'       => __( 'Use With', 'pedalcms' ),
								'name'        => 'college_object_type',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Choose the features to use this taxonomy with.', 'pedalcms' ),
								'options'     => [
									'pdl_program' => __( 'Programs', 'pedalcms' ),
									'pdl_course'  => __( 'Course Catalog', 'pedalcms' ),
									'pdl_person'  => __( 'Faculty & Staff Directory', 'pedalcms' ),
								],
								'default'     => [ 'pdl_program', 'pdl_course', 'pdl_person' ],
							],

							// --- Department ---
							[
								'label'       => __( 'Department', 'pedalcms' ),
								'name'        => 'department_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Used by Programs, Course Catalog, and Faculty & Staff Directory.</span>',
							],

							[
								'label'       => __( 'Enable', 'pedalcms' ),
								'name'        => 'department_enable',
								'type'        => 'conditional_checkbox',
								'class'       => 'is-fancy-toggle',
								'conditional' => [ 'department_enable_archive', 'department_depends_college' ],
								'default'     => 1,
							],

							[
								'label'       => __( 'Enable Archive', 'pedalcms' ),
								'name'        => 'department_enable_archive',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'If disabled, links will point to a filtered programs view.', 'pedalcms' ),
								'default'     => 1,
							],

							[
								'label'       => __( 'Depends on College', 'pedalcms' ),
								'name'        => 'department_depends_college',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'If enabled, Departments will belong to a College and the relationship will be enforced.', 'pedalcms' ),
								'default'     => 1,
							],

							[
								'label'       => __( 'Singular Label', 'pedalcms' ),
								'name'        => 'department_label_single',
								'type'        => 'text',
								'placeholder' => __( 'Department', 'pedalcms' ),
							],

							[
								'label'       => __( 'Plural Label', 'pedalcms' ),
								'name'        => 'department_label_plural',
								'type'        => 'text',
								'placeholder' => __( 'Departments', 'pedalcms' ),
							],

							[
								'label'       => __( 'Use With', 'pedalcms' ),
								'name'        => 'department_object_type',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'Choose the features to use this taxonomy with.', 'pedalcms' ),
								'options'     => [
									'pdl_program' => __( 'Programs', 'pedalcms' ),
									'pdl_course'  => __( 'Course Catalog', 'pedalcms' ),
									'pdl_person'  => __( 'Faculty & Staff Directory', 'pedalcms' ),
								],
								'default'     => [ 'pdl_program', 'pdl_course', 'pdl_person' ],
							],

							// --- Program Type ---
							[
								'label'       => __( 'Program Type', 'pedalcms' ),
								'name'        => 'program_type_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Used by Programs.</span>',
							],

							[
								'label'   => __( 'Enable', 'pedalcms' ),
								'name'    => 'program_type_enable',
								'type'    => 'checkbox',
								'class'   => 'is-fancy-toggle',
								'default' => 1,
							],

							[
								'label'       => __( 'Enable Archive', 'pedalcms' ),
								'name'        => 'program_type_enable_archive',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'If disabled, links will point to a filtered programs view.', 'pedalcms' ),
								'default'     => 1,
							],

							[
								'label'       => __( 'Singular Label', 'pedalcms' ),
								'name'        => 'program_type_label_single',
								'type'        => 'text',
								'placeholder' => __( 'Program Type', 'pedalcms' ),
							],

							[
								'label'       => __( 'Plural Label', 'pedalcms' ),
								'name'        => 'program_type_label_plural',
								'type'        => 'text',
								'placeholder' => __( 'Program Types', 'pedalcms' ),
							],

							// --- Instruction Mode ---
							[
								'label'       => __( 'Instruction Mode', 'pedalcms' ),
								'name'        => 'instruction_mode_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Used by Programs. (e.g. In-person, Online, Hybrid)</span>',
							],

							[
								'label'   => __( 'Enable', 'pedalcms' ),
								'name'    => 'instruct_mode_enable',
								'type'    => 'checkbox',
								'class'   => 'is-fancy-toggle',
								'default' => 1,
							],

							[
								'label'       => __( 'Singular Label', 'pedalcms' ),
								'name'        => 'instruct_mode_label_single',
								'type'        => 'text',
								'placeholder' => __( 'Instruction Mode', 'pedalcms' ),
							],

							[
								'label'       => __( 'Plural Label', 'pedalcms' ),
								'name'        => 'instruct_mode_label_plural',
								'type'        => 'text',
								'placeholder' => __( 'Instruction Modes', 'pedalcms' ),
							],

							// --- Subject ---
							[
								'label'       => __( 'Subject', 'pedalcms' ),
								'name'        => 'subject_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Used in the Course Catalog.</span>',
							],

							[
								'label'   => __( 'Enable', 'pedalcms' ),
								'name'    => 'subject_enable',
								'type'    => 'checkbox',
								'class'   => 'is-fancy-toggle',
								'default' => 1,
							],

							[
								'label'       => __( 'Singular Label', 'pedalcms' ),
								'name'        => 'subject_label_single',
								'type'        => 'text',
								'placeholder' => __( 'Subject', 'pedalcms' ),
							],

							[
								'label'       => __( 'Plural Label', 'pedalcms' ),
								'name'        => 'subject_label_plural',
								'type'        => 'text',
								'placeholder' => __( 'Subjects', 'pedalcms' ),
							],

							// --- Session ---
							[
								'label'       => __( 'Session', 'pedalcms' ),
								'name'        => 'session_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Used in the Course Catalog. Also commonly referred to as "term." (e.g. Fall, Spring, Summer)</span>',
							],

							[
								'label'   => __( 'Enable', 'pedalcms' ),
								'name'    => 'session_enable',
								'type'    => 'checkbox',
								'class'   => 'is-fancy-toggle',
								'default' => 1,
							],

							[
								'label'       => __( 'Singular Label', 'pedalcms' ),
								'name'        => 'session_label_single',
								'type'        => 'text',
								'placeholder' => __( 'Session', 'pedalcms' ),
							],

							[
								'label'       => __( 'Plural Label', 'pedalcms' ),
								'name'        => 'session_label_plural',
								'type'        => 'text',
								'placeholder' => __( 'Sessions', 'pedalcms' ),
							],

							// --- Personnel Category ---
							[
								'label'       => __( 'Personnel Category', 'pedalcms' ),
								'name'        => 'person_cat_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Used by personnel.</span>',
							],

							[
								'label'   => __( 'Enable', 'pedalcms' ),
								'name'    => 'person_cat_enable',
								'type'    => 'checkbox',
								'class'   => 'is-fancy-toggle',
								'default' => 1,
							],

							[
								'label'       => __( 'Enable Archive', 'pedalcms' ),
								'name'        => 'person_cat_enable_archive',
								'type'        => 'checkbox',
								'class'       => 'is-fancy-toggle',
								'description' => __( 'If disabled, links will point to a filtered directory view.', 'pedalcms' ),
								'default'     => 1,
							],

							[
								'label'       => __( 'Singular Label', 'pedalcms' ),
								'name'        => 'person_cat_label_single',
								'type'        => 'text',
								'placeholder' => __( 'Personnel Category', 'pedalcms' ),
							],

							[
								'label'       => __( 'Plural Label', 'pedalcms' ),
								'name'        => 'person_cat_label_plural',
								'type'        => 'text',
								'placeholder' => __( 'Personnel Categories', 'pedalcms' ),
							],

							// --- FAQ Category ---
							[
								'label'       => __( 'FAQ Category', 'pedalcms' ),
								'name'        => 'faq_cat_group',
								'type'        => 'custom_html',
								'content'	  => '<span class="pdl-group-description">Used by programs.</span>',
							],

							[
								'label'       => __( 'Singular Label', 'pedalcms' ),
								'name'        => 'faq_cat_label_single',
								'type'        => 'text',
								'placeholder' => __( 'FAQ Category', 'pedalcms' ),
							],

							[
								'label'       => __( 'Plural Label', 'pedalcms' ),
								'name'        => 'faq_cat_label_plural',
								'type'        => 'text',
								'placeholder' => __( 'FAQ Categories', 'pedalcms' ),
							],

						], // end taxonomies fields
					],

				], // end tabs
			],

		], // end metabox fields
	],

]; // end return

return apply_filters( 'pdl/cassette/fields/settings', $fields );
