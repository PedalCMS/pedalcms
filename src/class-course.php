<?php

namespace PedalCMS\Core;

/**
 * Course custom post type.
 *
 * @package PedalCMS\Core\ContentModel
 * @since 0.1.0
 */
class Course extends CustomPostType {
	/**
	 * @inheritdoc
	 */
	public const POST_TYPE = 'pdl_course';

	/**
	 * @inheritdoc
	 */
	public array $args = [
		'rewrite'         => [ 'slug' => 'course' ],
		'has_archive'     => 'courses',
		'capability_type' => self::POST_TYPE,
		'menu_icon'       => '',
		'menu_position'   => 5,
		'description'     => '',
		'public'          => true,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'query_var'       => true,
		'map_meta_cap'    => true,
		'hierarchical'    => false,
		'supports'        => [ 'title', 'editor' ],
	];

	/**
	 * @inheritdoc
	 */
	protected function setup_labels(): void {
		$this->args['labels'] = [
			'name'                     => _x( 'Course Catalog', 'post type general name', 'pedalcms' ),
			'singular_name'            => _x( 'Course', 'post type singular name', 'pedalcms' ),
			'plural_not_collective'    => _x( 'Courses', 'post type plural name not collective', 'pedalcms' ),
			'add_new_item'             => __( 'Add New Course', 'pedalcms' ),
			'edit_item'                => __( 'Edit Course', 'pedalcms' ),
			'new_item'                 => __( 'New Course', 'pedalcms' ),
			'view_item'                => __( 'View Course', 'pedalcms' ),
			'view_items'               => __( 'View Courses', 'pedalcms' ),
			'search_items'             => __( 'Search Courses', 'pedalcms' ),
			'not_found'                => __( 'No courses found.', 'pedalcms' ),
			'not_found_in_trash'       => __( 'No courses found in Trash.', 'pedalcms' ),
			'parent_item_colon'        => __( 'Parent Course:', 'pedalcms' ),
			'all_items'                => __( 'All Courses', 'pedalcms' ),
			'archives'                 => __( 'Course Catalog', 'pedalcms' ),
			'attributes'               => __( 'Course Attributes', 'pedalcms' ),
			'insert_into_item'         => __( 'Insert into course', 'pedalcms' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this course', 'pedalcms' ),
			'filter_items_list'        => __( 'Filter courses list', 'pedalcms' ),
			'items_list_navigation'    => __( 'Courses list navigation', 'pedalcms' ),
			'items_list'               => __( 'Courses list', 'pedalcms' ),
			'item_published'           => __( 'Course published.', 'pedalcms' ),
			'item_published_privately' => __( 'Course published privately.', 'pedalcms' ),
			'item_reverted_to_draft'   => __( 'Course reverted to draft.', 'pedalcms' ),
			'item_scheduled'           => __( 'Course scheduled.', 'pedalcms' ),
			'item_updated'             => __( 'Course updated.', 'pedalcms' ),
			'item_link'                => _x( 'Course Link', 'navigation link block title', 'pedalcms' ),
			'item_link_description'    => _x( 'A link to a course.', 'navigation link block description', 'pedalcms' ),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function setup_hooks(): void {
		add_action( 'pre_get_posts', [ static::class, 'update_sort_order' ] );
	}

	/**
	 * Changes the sort order for Programs.
	 *
	 * Called on filter: pre_get_posts
	 *
	 * @since 0.1.0
	 *
	 * @param WP_Query $query The current WP_Query
	 * @return void
	 */
	public static function update_sort_order( \WP_Query $query ): void {
		$update_order =
			$query->is_main_query() &&
			! is_admin() &&
			! $query->get( 'orderby' ) &&
			$query->is_post_type_archive( self::POST_TYPE );

		if ( $update_order ) {
			$query->set( 'order', 'ASC' );
			$query->set( 'orderby', 'title' );
		}
	}   /**
	 * Prefixes the course title with the course code.
	 *
	 * @since 0.1.0
	 *
	 * @param mixed $post Either the ID of a post or a WP_Post object. Deafults to the current course.
	 * @return string The full title.
	 */
	public static function get_full_title( $post = null ): string {
		$post  = get_post( $post );
		$title = '';

		if ( $post->course_code ) {
			$title .= sprintf(
				'<span class="course-code">%s</span> <span class="separator">&ndash;</span>',
				esc_html( $post->course_code )
			);
		}

		$title .= sprintf(
			'<span class="course-name">%s</span>',
			// TODO: should this be a call to get_the_title?
			esc_html( $post->post_title )
		);

		// TODO: Filter this or consider .
		return $title;
	}

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
	public static function get_action_link( string $action, $course = null ): string {
		$course = get_post( $course );

		$url = get_post_meta( $course->ID, 'url_' . $action, true );

		if ( $url ) {
			return $url;
		}

		$url = \PedalCMS\Core\Plugin::get_option( 'course_url_' . $action );

		if ( $url ) {
			$url = str_replace(
				[
					'{$course_cat_key}',
					'{$course_reg_key}',
				],
				[
					(string) get_post_meta( $course->ID, 'course_catalog_key', true ),
					(string) get_post_meta( $course->ID, 'course_registration_key', true ),
				],
				$url
			);

			return $url;
		}

		return '';
	}
}
