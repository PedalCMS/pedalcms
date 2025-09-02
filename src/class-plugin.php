<?php

namespace PedalCMS\Core;

/**
 * Handles all global settings and setup.
 *
 * @package PedalCMS
 * @since 0.1.0
 */
class Plugin {
	/**
	 * Slug style name of the plugin. Should match folder name.
	 *
	 * @var string
	 */
	public static $name = 'pedalcms';

	/**
	 * Absolute path of the plugin root.
	 *
	 * @var string
	 */
	public static $path = '';

	/**
	 * URL of the plugin root.
	 *
	 * @var string
	 */
	public static $url = '';

	/**
	 * Template folder name.
	 *
	 * @var string
	 */
	public static $template_path = '/templates';

	/**
	 * Whether the plugin has already been initialized.
	 *
	 * @var boolean
	 */
	private static $_init = false;

	/**
	 * Config for reistering ACF options page.
	 *
	 * @var array
	 */
	public static $options_page;

	/**
	 * The admin page slug for the options page.
	 *
	 * @var string
	 */
	public static $options_page_slug = 'pedalcms-settings';

	/**
	 * The link to the parent menu item of the options page.
	 *
	 * @var string
	 */
	public static $options_page_parent = 'edit.php?post_type=' . Program::POST_TYPE;

	/**
	 * All regist strings/labels to the plugin to be output on the front end of the site.
	 *
	 * Ex: 'More Details'
	 *
	 * @var array
	 */
	public static $labels = [];

	/**
	 * Stores ACF field group config
	 *
	 * @var array
	 */
	public static $field_groups = [];

	/**
	 * Stores the list of post types available in this plugin.
	 *
	 * @var array
	 */
	private static $post_types = [];

	/**
	 * Stores the list of post types currently enabled and registered by this plugin.
	 *
	 * @var array
	 */
	private static $post_types_enabled = [];

	/**
	 * Stores the list of taxonomies available in this plugin.
	 *
	 * @var array
	 */
	private static $taxonomies = [];

	/**
	 * Stores the list of taxonomies currently enabled and registered by this plugin.
	 *
	 * @var array
	 */
	private static $taxonomies_enabled = [];

	/**
	 * Kicks off the whole plugin setup.
	 */
	public function __construct() {
		if ( self::$_init ) {
			return;
		}

		self::$path          = dirname( __DIR__ );
		self::$url           = plugins_url( self::$name );
		self::$template_path = self::$path . self::$template_path;

		add_action( 'init', [ self::class, 'plugin_init' ], 0 );
		add_action( 'plugin_action_links', [ self::class, 'add_settings_link' ], 10, 2 );

		self::$_init = true;
	}

	/**
	 * Handles install tasks for the plugin.
	 *
	 * @return void
	 */
	public static function install() {
		Program::setup_subpage_manager();
		self::register_content_model();
		self::install_capabilities();
		flush_rewrite_rules();
	}

	/**
	 * Adds capabilities for the entire content model to the Administrator role.
	 *
	 * @return void
	 */
	public static function install_capabilities() {
		$role           = get_role( 'administrator' );
		$post_type_args = [
			(object) Program::get_instance()->args,
			(object) Person::get_instance()->args,
			(object) Course::get_instance()->args,
			(object) FAQ::get_instance()->args,
		];

		foreach ( $post_type_args as $args ) {
			$args->capabilities = [];

			$caps = get_post_type_capabilities( $args );

			foreach ( $caps as $cap ) {
				$role->add_cap( $cap );
			}
		}
	}

	/**
	 * Performs some plugin setup.
	 *
	 * Called on action: init
	 *
	 * @return void
	 */
	public static function plugin_init(): void {
		load_plugin_textdomain(
			self::$name,
			false,
			self::$name . '/languages/'
		);

		// NOTE: This has to be done before init_field_group.
		Program::setup_subpage_manager();

		self::setup_options_page();
		self::setup_field_group();
		self::setup_labels();

		self::register_content_model();
		self::register_custom_blocks();
		self::setup_template_manager();
	}

	/**
	 * Loads configuration of the ACF field group.
	 *
	 * @return void
	 */
	public static function setup_field_group(): void {
		require_once self::$path . '/src/field-group-plugin.php';

		self::$field_groups[] = $field_group;
	}

	/**
	 * Returns the plugin's field group.
	 *
	 * @return array The field group.
	 */
	public static function get_field_group(): array {
		return static::$field_groups[0] ?? [];
	}

	/**
	 * Sets up the options page config.
	 *
	 * @return void
	 */
	private static function setup_options_page() {
		self::$options_page = [
			'page_title'  => __( 'Pedal CMS Settings', 'pedalcms' ),
			'menu_title'  => _x( 'Settings', 'menu item title', 'pedalcms' ),
			'menu_slug'   => self::$options_page_slug,
			'capability'  => 'manage_options',
			'parent_slug' => self::$options_page_parent,
			'position'    => 100,
			'redirect'    => false,
		];
	}

	/**
	 * Initializes the label repository.
	 *
	 * @return void
	 */
	private static function setup_labels() {
		self::$labels = [
			'more_details'          => __( 'More Details', 'pedalcms' ),
			'no_one_found'          => __( 'No one was found.', 'pedalcms' ),
			'no_programs_found'     => __( 'No programs were found.', 'pedalcms' ),
			'prerequisites'         => __( 'Prerequisites', 'pedalcms' ),
			'yes'                   => __( 'Yes', 'pedalcms' ),
			'no'                    => __( 'No', 'pedalcms' ),
			'phone'                 => _x( 'Phone', 'noun', 'pedalcms' ),
			'email'                 => _x( 'Email', 'noun', 'pedalcms' ),
			'office'                => __( 'Office', 'pedalcms' ),
			'filter'                => __( 'Filter', 'pedalcms' ),
			'show'                  => __( 'Show', 'pedalcms' ),
			'hide'                  => __( 'Hide', 'pedalcms' ),
			'more_filters'          => __( 'More Filters', 'pedalcms' ),
			'apply_filters'         => __( 'Search', 'pedalcms' ),
			'reset_filters'         => __( 'Reset Filters', 'pedalcms' ),
			'missing_filters_data'  => __( 'Missing data to render filters.', 'pedalcms' ),
			/* translators: The placeholder is the name of the filter. It will be translated separately. */
			'missing_filter_data'   => __( 'Missing data to render %s filter', 'pedalcms' ),
			'filtered_results'      => __( 'Filtered Results', 'pedalcms' ),
			'showing'               => __( 'Showing', 'pedalcms' ),
			/* translators: Number of results (e.g. 'Showing 1-10 of 120 posts'). Note: the last placeholder is the name of the post_type.  */
			'showing_of'            => __( 'Showing %1$s–%2$s of %3$s %4$s.', 'pedalcms' ),
			'keyword'               => __( 'Keyword', 'pedalcms' ),
			'none_selected_prefix'  => __( 'Any ', 'pedalcms' ),
			'credit'                => __( 'credit', 'pedalcms' ),
			'credits'               => __( 'credits', 'pedalcms' ),
			'offered_in'            => __( 'Offered in', 'pedalcms' ),
			'instructors'           => __( 'Instructors', 'pedalcms' ),
			'courses_taught'        => __( 'Courses Taught', 'pedalcms' ),
			'program_subnav'        => __( 'Program Subnav', 'pedalcms' ),
			'about_program'         => __( 'About this Program', 'pedalcms' ),
			'application_deadlines' => __( 'Application Deadlines', 'pedalcms' ),
			'program_contact'       => __( 'Program Contact', 'pedalcms' ),
			'contact_action'        => __( 'Contact', 'pedalcms' ),
			'featured'              => __( 'Featured', 'pedalcms' ),
			'read_more'             => __( 'Read More', 'pedalcms' ),
			'show_all_posts'        => __( 'Show All Posts', 'pedalcms' ),
			'program_details'       => __( 'Program Details', 'pedalcms' ),
			'apply_now_action'      => __( 'Apply Now', 'pedalcms' ),
			'request_info_action'   => __( 'Request Info', 'pedalcms' ),
			'estimated_cost'        => __( 'Estimated Cost', 'pedalcms' ),
			'register_action'       => __( 'Register', 'pedalcms' ),
			'back_to_top'           => __( 'Back to Top', 'pedalcms' ),
		];
	}

	/**
	 * Add settings link to plugin actions.
	 *
	 * Called on filter: `plugin_action_links`
	 *
	 * @since 0.1.0
	 *
	 * @param string[] $actions The current list of actions.
	 * @param $plugin_file The file name identifier of the current plugin (e.g. pedalcms/pedalcms.php).
	 *
	 * @return string[] The filtered actions.
	 */
	public static function add_settings_link( $actions, $plugin_file ) {
		$this_plugin = sprintf( '%1$s/%1$s.php', self::$name );

		if ( $this_plugin === $plugin_file ) {
			$link = sprintf( '%s&page=%s', self::$options_page_parent, self::$options_page_slug );
			array_unshift( $actions, sprintf( '<a href="%s">Settings</a>', $link ) );
		}

		return $actions;
	}

	/**
	 * Registers all the custom post types and custom taxonomies.
	 *
	 * @return void
	 */
	public static function register_content_model(): void {
		Program::get_instance()->register();
		self::$post_types[]         = Program::POST_TYPE;
		self::$post_types_enabled[] = Program::POST_TYPE;

		self::$post_types[] = Course::POST_TYPE;
		if ( self::get_option( 'course_enable' ) ) {
			Course::get_instance()->register();
			self::$post_types_enabled[] = Course::POST_TYPE;
		}

		self::$post_types[] = Person::POST_TYPE;
		if ( self::get_option( 'person_enable' ) ) {
			Person::get_instance()->register();
			self::$post_types_enabled[] = Person::POST_TYPE;
		}

		self::$post_types[] = FAQ::POST_TYPE;
		$enabled_subpages   = Program::subpage_manager()->get_enabled_subpages();

		if ( is_array( $enabled_subpages ) && in_array( 'faqs', $enabled_subpages, true ) ) {
			FAQ::get_instance()->register();
			self::$post_types_enabled[] = FAQ::POST_TYPE;
		}

		self::$taxonomies[] = PersonCategory::TAXONOMY;
		if ( self::get_option( 'person_cat_enable' ) ) {
			PersonCategory::get_instance()->register();
			self::$taxonomies_enabled[] = PersonCategory::TAXONOMY;
		}

		self::$taxonomies[] = College::TAXONOMY;
		if ( self::get_option( 'college_enable' ) ) {
			College::get_instance()->register();
			self::$taxonomies_enabled[] = College::TAXONOMY;
		}

		self::$taxonomies[] = Department::TAXONOMY;
		if ( self::get_option( 'department_enable' ) ) {
			Department::get_instance()->register();
			self::$taxonomies_enabled[] = Department::TAXONOMY;
		}

		self::$taxonomies[] = ProgramType::TAXONOMY;
		if ( self::get_option( 'program_type_enable' ) ) {
			ProgramType::get_instance()->register();
			self::$taxonomies_enabled[] = ProgramType::TAXONOMY;
		}

		self::$taxonomies[] = InstructionMode::TAXONOMY;
		if ( self::get_option( 'instruct_mode_enable' ) ) {
			InstructionMode::get_instance()->register();
			self::$taxonomies_enabled[] = InstructionMode::TAXONOMY;
		}

		self::$taxonomies[] = Subject::TAXONOMY;
		if ( self::get_option( 'subject_enable' ) ) {
			Subject::get_instance()->register();
			self::$taxonomies_enabled[] = Subject::TAXONOMY;
		}

		self::$taxonomies[] = Session::TAXONOMY;
		if ( self::get_option( 'session_enable' ) ) {
			Session::get_instance()->register();
			self::$taxonomies_enabled[] = Session::TAXONOMY;
		}

		self::$taxonomies[] = FAQCategory::TAXONOMY;
		FAQCategory::get_instance()->register();
		self::$taxonomies_enabled[] = FAQCategory::TAXONOMY;
	}

	/**
	 * Gets the list of post types available or registered by this plugin.
	 *
	 * @since 0.1.0
	 *
	 * @param bool $enabled_only Whether or not to only return enabled post types.
	 * @return array An array of post type keys.
	 */
	public static function post_types( bool $enabled_only = true ): array {
		if ( $enabled_only ) {
			return self::$post_types_enabled;
		}

		return self::$post_types;
	}

	/**
	 * Gets the list of taxonomies available or registered by this plugin.
	 *
	 * @since 0.1.0
	 *
	 * @param bool $enabled_only Whether or not to only return enabled taxonomies.
	 * @return array An array of taxonomy keys.
	 */
	public static function taxonomies( bool $enabled_only = true ): array {
		if ( $enabled_only ) {
			return self::$taxonomies_enabled;
		}

		return self::$taxonomies;
	}

	/**
	 * Returns an associative array of taxonomies indexed by their search filter name.
	 *
	 * @return array The search filter to taxonomy map.
	 */
	public static function get_tax_filters_map(): array {
		static $map = null;

		if ( ! $map ) {
			$filters = array_map(
				function ( $a ) {
					return str_replace(
						[ 'pdl_', '_' ],
						[ '', '-' ],
						$a
					);
				},
				self::$taxonomies
			);

			$map = array_combine( $filters, self::$taxonomies );
		}

		return $map;
	}

	/**
	 * Registers custom Gutenberg blocks for the entire plugin.
	 *
	 * @return void
	 */
	public static function register_custom_blocks(): void {
		if ( ! Person::is_block_editor_enabled() ) {
			return;
		}

		new JobTitleBlock();
		new ContactInfoBlock();
	}

	/**
	 * Creates and configures the template manager.
	 *
	 * @return void
	 */
	public static function setup_template_manager(): void {
		$templates  = [];
		$post_types = self::post_types();
		$taxonomies = self::taxonomies();

		foreach ( $post_types as $post_type ) {
			$template    = TemplateManager::convert_obj_name_to_template( $post_type );
			$templates[] = [
				'name'     => 'single-' . $template,
				'callback' => 'is_singular',
				'args'     => [ $post_type ],
			];
			$templates[] = [
				'name'     => 'archive-' . $template,
				'callback' => 'is_post_type_archive',
				'args'     => [ $post_type ],
			];
		}

		foreach ( $taxonomies as $taxonomy ) {
			$template    = TemplateManager::convert_obj_name_to_template( $taxonomy );
			$templates[] = [
				'name'     => 'taxonomy-' . $template,
				'callback' => 'is_tax',
				'args'     => [ $taxonomy ],
			];
		}

		$pdl_TemplateManager = new TemplateManager(
			self::$template_path,
			self::$name,
			$templates
		);

		add_filter( 'template_include', [ $pdl_TemplateManager, 'maybe_use_template' ], PHP_INT_MAX );
	}

	/**
	 * Returns a label from the plugin wide registry.
	 *
	 * @param string $label_key The key of the label to retrieve.
	 * @return string The requested label on success, "label not found" message on failure.
	 */
	public static function get_label( string $label_key ): string {
		$label = self::get_option( 'label_' . $label_key );

		if ( ! $label ) {
			$label = self::$labels[ $label_key ] ??
				sprintf(
					/* translators: the argument is the key of the label */
					__( 'Label "%s" not found', 'pedalcms' ),
					$label_key
				);
		}

		$label = apply_filters( 'pdl/get_label', $label, $label_key, 'programs' );

		return $label;
	}

	/**
	 * Retrieves a plugin setting.
	 *
	 * @param string $option The name of the setting.
	 * @param mixed $default The fallback value for the setting.
	 * @return mixed The value of the setting.
	 */
	public static function get_option( string $option, mixed $default = null ): mixed {
		$value = get_option( 'options_pdl_' . $option, $default );

		/**
		 * Filters the value of all options.
		 *
		 * @since 0.2.1
		 *
		 * @param $value The value of the option.
		 * @param $option The name of the option.
		 */
		/**
		 * Filters the value of a single option. The last part of the filter is the name of the option.
		 *
		 * @since 0.1
		 *
		 * @param $value The value of the option.
		 */
		return apply_filters( "pdl/options/{$option}", $value );
	}
}
