<?php
/**
 * Template tags specifically for this plugin.
 *
 * @package PedalCMS
 * @since 0.1.0
 */

if ( ! function_exists( 'pdl_get_template_part' ) ) :
	/**
	 * Outputs a template.
	 *
	 * Alias of TemplateManager::load_template()
	 *
	 * @since 0.1.0
	 * @see TemplateManager::load_template
	 *
	 * @param string $template The requested template file. Can include subdir.
	 * @param array $data Data to pass to the requested template.
	 * @return void
	 */
	function pdl_get_template_part( string $template, array $data = [] ) {
		\PedalCMS\Core\TemplateManager::load_template( $template, $data );
	}

endif;

if ( ! function_exists( 'pdl_get_label' ) ) :
	/**
	 * Alias of {@see PedalCMS\Core\Plugin::get_label()}.
	 *
	 * @since 0.1.0
	 *
	 * @param string $label The machine name of the label.
	 * @return string The human readable version of label.
	 */
	function pdl_get_label( string $label ): string {
		return \PedalCMS\Core\Plugin::get_label( $label );
	}

endif;


if ( ! function_exists( 'pdl_get_post_types' ) ) :
	/**
	 * Gets the list of post types registered by this plugin.
	 *
	 * @since 0.1.0
	 *
	 * @return array An array of post type keys.
	 */
	function pdl_get_post_types(): array {
		return \PedalCMS\Core\Plugin::post_types();
	}

endif;

if ( ! function_exists( 'pdl_get_archive_title' ) ) :
	/**
	 * Gets the current archive title.
	 *
	 * This function merely subverts `get_the_archive_title`  when it is a post
	 * type archive to prevent "Archives:" from being prepended to the title.
	 *
	 * @return string
	 */
	function pdl_get_archive_title(): string {
		$title = '';

		if ( is_post_type_archive( \PedalCMS\Core\Plugin::post_types() ) ) {
			$title = post_type_archive_title( '', false );
		} else {
			$title = get_the_archive_title();
		}

		return $title;
	}

endif;

if ( ! function_exists( 'pdl_get_option' ) ) :
	/**
	 * Gets a plugin option setting.
	 *
	 * @param string $option The option key.
	 * @return mixed The option value.
	 */
	function pdl_get_option( string $option ) {
		return \PedalCMS\Core\Plugin::get_option( $option );
	}

endif;


if ( ! function_exists( 'pdl_register_program_subpage' ) ) :
	/**
	 * Registers a new program subpage.
	 *
	 * You must also provide a template to render the subpage. It should be located
	 * here:
	 * {$theme-name}/pedalcms/single-program/subpages/{$slug}.php
	 *
	 * By default, all registered subpages are enabled for all programs. It is up
	 * to you to handle cases where these should be displayed on a program by
	 * program basis. See filter {@see 'pdl/maybe_show_subpage'}.
	 *
	 * @since 0.1.0
	 *
	 * @param string $slug The URL slug of the new {@see \PedalCMS\Core\Subpage}.
	 * @param array $args Array of args for registering a subpage. See {@see \PedalCMS\Core\Subpage::_constructor()} for list.
	 * @return mixed The Subpage object on success. WP_Error on failure.
	 */
	function pdl_register_program_subpage( string $slug, array $args = [] ) {
		// TODO: Consider moving this out of template tags.
		$args['builtin'] = false;
		$subpage         = new \PedalCMS\Core\Subpage( $slug, $args );

		return \PedalCMS\Core\Program::subpage_manager()->add_subpage( $subpage );
	}

endif;


if ( ! function_exists( 'pdl_register_filter' ) ) :
	/**
	 * Registers a reusable archive filter.
	 *
	 * Intended to be called on the `pdl/register_filters` action. See
	 * {@see \PedalCMS\Core\FilterManager::register()} for the accepted args.
	 *
	 * @since 0.1.0
	 *
	 * @param string $slug The filter slug (also the default query var).
	 * @param array  $args Filter definition.
	 * @return array|\WP_Error The stored definition on success, WP_Error on failure.
	 */
	function pdl_register_filter( string $slug, array $args = [] ) {
		return \PedalCMS\Core\FilterManager::get_instance()->register( $slug, $args );
	}

endif;


if ( ! function_exists( 'pdl_show_subpages' ) ) :
	/**
	 * Determines whether or not to display Program subpages.
	 *
	 * @since 0.1.0
	 *
	 * @return bool
	 */
	function pdl_show_subpages(): bool {
		return count(
			\PedalCMS\Core\Program::subpage_manager()->get_subpages()
		);
	}

endif;


if ( ! function_exists( 'pdl_get_subpages' ) ) :
	/**
	 * Returns the registered list of Program subpages.
	 *
	 * Alias of {@see \PedalCMS\Core\SubpageManager::get_subpages()}
	 *
	 * @since 0.1.0
	 *
	 * @param bool $with_index Whether or not to include the index. Defaults to true.
	 * @param string $return_type Can be 'hash' or 'objects'. Defaults to 'objects'.
	 * @return array List of subpages
	 */
	function pdl_get_subpages( bool $with_index = true, string $return_type = 'objects' ): array {
		return \PedalCMS\Core\Program::subpage_manager()->get_subpages( $with_index, $return_type );
	}

endif;


if ( ! function_exists( 'pdl_get_active_subpage' ) ) :
	/**
	 * Returns the active subpage by slug.
	 *
	 * Alias of {@see \PedalCMS\Core\SubpageManager::get_active_subpage()}. Should only be called
	 * in the context of a single program.
	 *
	 * @since 0.1.0
	 *
	 * @param string $return_type The format of the returned subpage. Either 'slug' or 'object'. Defaults to 'slug'.
	 * @return mixed The active subpage, either slug or the full object. False if active page not found.
	 */
	function pdl_get_active_subpage( string $return_type = 'slug' ) {
		return \PedalCMS\Core\Program::subpage_manager()->get_active_subpage( $return_type );
	}

endif;


if ( ! function_exists( 'pdl_show_subpage' ) ) :
	/**
	 * Determines whether a particular subpage should be rendered.
	 *
	 * Alias of {@see \PedalCMS\Core\SubpageManager::maybe_show_subpage()}.
	 *
	 * @since 0.1.0
	 *
	 * @param mixed $subpage Either a {@see PedalCMS\Core\Subpage} or the slug of one.
	 * @return boolean
	 */
	function pdl_show_subpage( $subpage ): bool {
		return \PedalCMS\Core\Program::subpage_manager()->maybe_show_subpage( $subpage );
	}

endif;


if ( ! function_exists( 'pdl_is_active_subpage' ) ) :
	/**
	 * Tests whether a subpage is currently active.
	 *
	 * Alias of {@see PedalCMS\Core\SubpageManager::is_active_subpage()}
	 *
	 * @since 0.1.0
	 *
	 * @param string $subpage The slug of the subpage to test.
	 * @return boolean
	 */
	function pdl_is_active_subpage( string $subpage ): bool {
		return \PedalCMS\Core\Program::subpage_manager()->is_active_subpage( $subpage );
	}

endif;


if ( ! function_exists( 'pdl_subpage_title' ) ) :
	/**
	 * Gets the content current subpage content title.
	 *
	 * @return string The current subpage title.
	 */
	function pdl_subpage_title(): string {
		$subpage = pdl_get_active_subpage( 'object' );

		if ( is_wp_error( $subpage ) ) {
			return $subpage->get_error_message();
		}

		return $subpage->title;
	}

endif;


if ( ! function_exists( 'pdl_subpage_link' ) ) :
	/**
	 * Generates a URL for a given subpage.
	 *
	 * Alias of {@see PedalCMS\Core\SubpageManager::get_subpage_link()}. Should only be called
	 * in the context of a single program.
	 *
	 * @since 0.1.0
	 *
	 * @param string $subpage The slug of the subpage.
	 * @param boolean $output Whether or not to output the URL. Defaults to true.
	 * @return string The subpage URL.
	 */
	function pdl_subpage_link( string $subpage, bool $output = true ): string {
		return \PedalCMS\Core\Program::subpage_manager()->get_subpage_link( $subpage, $output );
	}

endif;


if ( ! function_exists( 'pdl_get_subpage_class' ) ) :
	/**
	 * Generates the CSS class names for a subpage container.
	 *
	 * @since 0.1.0
	 *
	 * @return array The list of class name strings.
	 */
	function pdl_get_subpage_class(): array {
		$active = \PedalCMS\Core\Program::subpage_manager()->get_active_subpage();

		$classes = [
			'program-subpage-' . $active,
			'program-subpage',
		];

		/**
		 * Filters the list of CSS class names for the current post.
		 *
		 * @since 0.1
		 *
		 * @param string[] $classes An array of class names.
		 * @param string[] $subpage The slug of the current subpage.
		 */
		$classes = apply_filters( 'pdl/subpage_class', $classes, $active );

		return array_unique( $classes );
	}

endif;


if ( ! function_exists( 'pdl_subpage_class' ) ) :
	/**
	 * Outputs the current subpage class with the class attribute string.
	 *
	 * @since 0.1.0
	 *
	 * @see pdl_get_subpage_class()
	 * @return void
	 */
	function pdl_subpage_class() {
		printf(
			'class="%s"',
			esc_attr( implode( ' ', pdl_get_subpage_class() ) )
		);
	}

endif;


if ( ! function_exists( 'pdl_get_action_link' ) ) :
	/**
	 * Returns the full URL for a given program action.
	 *
	 * Will check for a local program override before attempting to build it from
	 * the plugin wide pattern setting.
	 *
	 * @since 0.1.0
	 *
	 * @param string $action The name of the action.
	 * @param mixed $program The ID of the program or a WP_Post object. Defaults to the current program.
	 * @return string The URL of the program action.
	 */
	function pdl_get_action_link( string $action, $program = null ): string {
		return \PedalCMS\Core\Program::get_action_link( $action, $program );
	}

endif;


if ( ! function_exists( 'pdl_get_course_action_link' ) ) :
	/**
	 * Returns the full URL for a given course action.
	 *
	 * Will check for a local course override before attempting to build it from
	 * the plugin wide pattern setting.
	 *
	 * @since 0.1.0
	 *
	 * @param string $action The name of the action.
	 * @param mixed $program The ID of the course or a WP_Post object. Defaults to the current course.
	 * @return string The URL of the course action.
	 */
	function pdl_get_course_action_link( string $action, $course = null ): string {
		return \PedalCMS\Core\Course::get_action_link( $action, $course );
	}

endif;


if ( ! function_exists( 'pdl_the_application_deadlines' ) ) :
	/**
	 * Gets a list of application deadlines based on override hierarchy.
	 *
	 * Alias of {@see PedalCMS\Core\Program::get_application_deadlines()}.
	 * Hierarchy is Program, College, Program Type, Global.
	 *
	 * @since 0.1.0
	 *
	 * @param mixed $program Program to check for news posts. Either ID or WP_Post. Defaults to the current program.
	 * @return array An ACF repeater field with deadline_label and deadline_info subfields.
	 */
	function pdl_the_application_deadlines( $program = null ): array {
		return \PedalCMS\Core\Program::get_application_deadlines( $program );
	}

endif;


if ( ! function_exists( 'pdl_get_related_posts' ) ) :
	/**
	 * Get the news posts for a given program by related tag.
	 *
	 * Alias of {@see PedalCMS\Core\Program::get_related_posts()}. Meta
	 * field news_tag must be set first.
	 *
	 * @since 0.1.0
	 *
	 * @param mixed $program Program to check for news posts. Either ID or WP_Post. Defaults to current program.
	 * @param array $not_in List of ids to exclude from the results. Deafults to empty array.
	 * @return array List of WP_Posts that match the Program's tag.
	 */
	function pdl_get_related_posts( $post = null, array $not_in = [] ): array {
		return \PedalCMS\Core\Program::get_related_posts( $post, $not_in );
	}

endif;


if ( ! function_exists( 'pdl_get_faqs_by_category' ) ) :
	/**
	 * Takes a list of FAQs and returns them indexed by category.
	 *
	 * Alias of {@see PedalCMS\Core\FAQ::group_by_category()}.
	 *
	 * @since 0.1.0
	 *
	 * @param array $faqs A list of FAQs of the type WP_Post.
	 * @return array The category indexed list of FAQs.
	 */
	function pdl_get_faqs_by_category( array $faqs ): array {
		return \PedalCMS\Core\FAQ::group_by_category( $faqs );
	}

endif;


if ( ! function_exists( 'normalize_faq_types' ) ) :
	/**
	 * Normalizes a list of FAQs of mixed type.
	 *
	 * Alias of {@see PedalCMS\Core\FAQ::normalize_faq_types()}.
	 *
	 * @since 0.1.0
	 *
	 * @param array $faqs A list of FAQs of mixed type WP_Post.
	 * @param bool $group_by_cat Whether to group by {@see PedalCMS\Core\FAQCategory}. Defaults to false.
	 * @return array The list of FAQs, either grouped by category or not.
	 */
	function normalize_faq_types( array $faqs, bool $group_by_cat = false ): array {
		return \PedalCMS\Core\FAQ::normalize_faq_types( $faqs, $group_by_cat );
	}

endif;


if ( ! function_exists( 'pdl_get_people_by_category' ) ) :
	/**
	 * Takes a list of People and returns them indexed by category.
	 *
	 * Alias of {@see PedalCMS\Core\Person::group_by_category()}.
	 *
	 * @since 0.1.0
	 *
	 * @param array $people A list of personnel of the type WP_Post.
	 * @return array The category indexed list of people.
	 */
	function pdl_get_people_by_category( array $people ): array {
		return \PedalCMS\Core\Person::group_by_category( $people );
	}

endif;


if ( ! function_exists( 'pdl_get_full_course_title' ) ) :
	/**
	 * Prefixes the course title with the course code.
	 *
	 * @since 0.1.0
	 *
	 * @param mixed $post Either the ID of a post or a WP_Post object. Deafults to the current course.
	 * @return string The full title.
	 */
	function pdl_get_full_course_title( $post = null ) {
		return \PedalCMS\Core\Course::get_full_title( $post );
	}

endif;

if ( ! function_exists( 'pdl_get_icon' ) ) :
	/**
	 * Gets an HTML string containing an inline SVG and wrapper tag.
	 *
	 * @since 0.1.0
	 *
	 * @link https://heroicons.com/
	 *
	 * @param string $icon The slug style name of a heroicon.
	 * @param array $args Arguments to control the size and style of the icon.
	 * @return string|false The resulting HTML string on success, false on failure.
	 */
	function pdl_get_icon( string $icon, array $args = [] ): string|false {
		$defaults = [
			'style' => 'solid',
			'size'  => 24,
			'class' => '',
		];

		$args = wp_parse_args( $args, $defaults );

		$style = sanitize_file_name( $args['style'] );
		$size  = (int) $args['size'];

		$icon = sanitize_file_name( $icon );
		$file = sprintf(
			'%sassets/img/heroicons/%d/%s/%s.svg',
			plugin_dir_path( __DIR__ ),
			$size,
			$style,
			$icon
		);

		$classes = explode( ' ', $args['class'] );
		$classes = array_map( 'sanitize_html_class', $classes );

		$classes = [
			'pdl-icon',
			'pdl-icon-' . $icon,
			'pdl-icon-' . $style,
			implode( ' ', $classes ),
		];

		if ( file_exists( $file ) ) {
			// Initialize WordPress filesystem for secure file operations.
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
			global $wp_filesystem;

			$file_contents = $wp_filesystem->get_contents( $file );
			if ( false !== $file_contents ) {
				return sprintf(
					'<span class="%s">%s</span>',
					implode( ' ', $classes ),
					$file_contents
				);
			}
		}

		return false;
	}
endif;

if ( ! function_exists( 'pdl_kses_svg' ) ) :
	/**
	 * Returns an allowed HTML array for use with wp_kses() that permits the safe
	 * subset of SVG tags and attributes used by inline heroicons, merged on top of
	 * the standard 'post' context allowed tags.
	 *
	 * @since 0.1.0
	 *
	 * @return array Allowed HTML tags and attributes.
	 */
	function pdl_kses_svg(): array {
		$svg_tags = [
			'svg'      => [
				'xmlns'       => true,
				'viewbox'     => true,
				'fill'        => true,
				'stroke'      => true,
				'aria-hidden' => true,
				'focusable'   => true,
				'role'        => true,
				'class'       => true,
				'width'       => true,
				'height'      => true,
				'id'          => true,
			],
			'path'     => [
				'd'               => true,
				'fill'            => true,
				'fill-rule'       => true,
				'clip-rule'       => true,
				'stroke'          => true,
				'stroke-width'    => true,
				'stroke-linecap'  => true,
				'stroke-linejoin' => true,
				'clip-path'       => true,
				'id'              => true,
				'class'           => true,
			],
			'g'        => [
				'fill'      => true,
				'stroke'    => true,
				'clip-path' => true,
				'id'        => true,
				'class'     => true,
			],
			'defs'     => [
				'id'    => true,
				'class' => true,
			],
			// wp_kses normalises tag names to lowercase, so clipPath → clippath.
			'clippath' => [
				'id'    => true,
				'class' => true,
			],
		];

		return array_merge( wp_kses_allowed_html( 'post' ), $svg_tags );
	}
endif;
