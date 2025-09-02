<?php

namespace PedalCMS\Core;

/**
 * Handles all functionality related to Subpages.
 *
 * @package PedalCMS\Core\Subpages
 * @since 0.1.0
 */
class SubpageManager {
	/**
	 * The query var to register.
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	private $post_type = '';

	/**
	 * The query var to register.
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	private $query_var = 'pdl_subpage';

	/**
	 * List of registered {@see \PedalCMS\Core\Subpage} objects, all of which are enabled.
	 *
	 * @since 0.1.0
	 *
	 * @var array
	 */
	private $subpages = [];

	/**
	 * List of all builtin {@see \PedalCMS\Core\Subpage} objects, whether enabled or not.
	 *
	 * @since 0.1.0
	 *
	 * @var array
	 */
	private $builtin = [];

	/**
	 * The current active Subpage object.
	 *
	 * A cache var that is initialized the first time get_active_subpage is
	 * called with the 'object' return type.
	 *
	 * @since 0.1.0
	 *
	 * @var Subpage
	 */
	private $active_subpage = null;

	/**
	 * Constructor
	 *
	 * @since 0.1.0
	 *
	 * @param string $post_type The post_type to the subpages will belong to.
	 * @param string $query_var The HTTP query parameter to register. Hidden when using pretty permalinks.
	 */
	public function __construct( string $post_type, string $query_var = '' ) {
		$this->post_type = $post_type;

		if ( $query_var ) {
			$this->query_var = $query_var;
		}

		$this->setup_hooks();
	}

	/**
	 * Registers all the hooks for the class.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function setup_hooks(): void {
		add_action( 'wp', [ &$this, 'maybe_override_rel_canonical' ] );
		add_action( 'init', [ &$this, 'insert_rules' ], 1 );
		add_filter( 'query_vars', [ &$this, 'add_query_var' ], 1 );
		add_filter( 'document_title_parts', [ &$this, 'maybe_update_title' ], 20 );
	}

	/**
	 * Registers a Subpage for the current post type.
	 *
	 * @since 0.1.0
	 *
	 * Builin subpages are tested against a plugin setting before being added
	 * to the active list but all are added to the builtin list.
	 *
	 * @param Subpage $subpage The subpage to register.
	 * @return mixed The registered {@see \PedalCMS\Core\Subpage} object on success. WP_Error on failure.
	 */
	public function add_subpage( Subpage $subpage ) {
		if ( $subpage->is_builtin() ) {
			$enabled = $this->get_enabled_subpages();

			$this->builtin[] = $subpage;
			$this->sort( 'builtin' );

			if ( 'index' !== $subpage->slug && ! in_array( $subpage->slug, $enabled, true ) ) {
				return new \WP_Error(
					'warning',
					'Subpage is not enabled.',
					$subpage
				);
			}
		}

		/**
		 * Filters the subpage to be registered.
		 *
		 * @since 0.1
		 *
		 * @param Subpage $subpage The subpage to be registered.
		 * @param string $post_type The post_type this subpage belongs to.
		 */
		$subpage = apply_filters( 'pdl/add_subpage', $subpage, $this->post_type );
		$subpage->before_add();
		$this->subpages[] = $subpage;
		$this->sort();

		return $subpage;
	}

	/**
	 * Checks that a given list is valid.
	 *
	 * @since 0.1.0
	 *
	 * @param string $list_name The list to validate.
	 * @return mixed The list argument returned if valid, WP_Error otherwise.
	 */
	private function check_list( string $list_name ) {
		$lists = [ 'subpages', 'builtin' ];
		if ( ! in_array( $list_name, $lists, true ) ) {
			return new \WP_Error(
				'error',
				'Trying to access unknown list: ' . $list_name
			);
		}

		return $list_name;
	}

	/**
	 * Sorts a given list by the subpages order property.
	 *
	 * @since 0.1.0
	 *
	 * @param string $list_name The list of subpages to sort. Defaults to 'subpages'.
	 * @return mixed Either true on success or WP_Error if given a bad list.
	 */
	public function sort( string $list_name = 'subpages' ) {
		$list_name = $this->check_list( $list_name );

		if ( is_wp_error( $list_name ) ) {
			return $list_name;
		}

		usort(
			$this->$list_name,
			function ( $a, $b ) {
				if ( $a->order === $b->order ) {
					return 0;
				}

				return ( $a->order < $b->order ) ? -1 : 1;
			}
		);

		return true;
	}

	/**
	 * Returns the list of current subpages.
	 *
	 * @since 0.1.0
	 *
	 * @param bool $with_index Whether or not to include the index.
	 * @param string $return_type Can be 'hash' or 'objects'.
	 * @return mixed List of subpages or WP_Error.
	 */
	public function get_subpages( bool $with_index = true, string $return_type = 'hash' ) {
		return $this->_get_subpages( $with_index, $return_type, 'subpages' );
	}

	/**
	 * Returns the list of builtin subpages.
	 *
	 * @since 0.1.0
	 *
	 * @param bool $with_index Whether or not to include the index.
	 * @param string $return_type Can be 'hash' or 'objects'.
	 * @return mixed List of subpages or WP_Error.
	 */
	public function get_builtin_subpages( bool $with_index = true, string $return_type = 'hash' ) {
		return $this->_get_subpages( $with_index, $return_type, 'builtin' );
	}

	/**
	 * Returns a list of subpages, either all builtin or all registered and enabled.
	 *
	 * @since 0.1.0
	 *
	 * @param bool $with_index Whether or not to include the index.
	 * @param string $return_type Can be 'hash' or 'objects'.
	 * @return mixed List of subpages or WP_Error.
	 */
	public function _get_subpages( bool $with_index = true, string $return_type = 'hash', $list_name = 'subpages' ) {
		$list_name = $this->check_list( $list_name );

		if ( is_wp_error( $list_name ) ) {
			return $list_name;
		}

		$subpages = $this->{$list_name};

		if ( ! $with_index ) {
			array_shift( $subpages );
		}

		$subpages = apply_filters( 'pdl/get_subpages', $subpages, $list_name, $this->post_type );

		if ( 'hash' === $return_type ) {
			return array_combine(
				wp_list_pluck( $subpages, 'slug' ),
				wp_list_pluck( $subpages, 'title' )
			);
		} elseif ( 'objects' !== $return_type ) {
			return new \WP_Error(
				'error',
				'Unrecognized return type: ' . $return_type
			);
		}

		return $subpages;
	}

	/**
	 * Register our custom query variable.
	 *
	 * Called on filter: `query_vars`
	 *
	 * @since 0.1.0
	 *
	 * @param array $vars The existing query vars.
	 * @return array The resulting query vars after we add ours.
	 */
	public function add_query_var( array $vars ): array {
		$vars[] = $this->query_var;

		return $vars;
	}

	/**
	 * Adds rewrite rules for programs subpages.
	 *
	 * Called on filter: `rewrite_rules_array`
	 *
	 * @since 0.1.0
	 */
	public function insert_rules() {
		$post_obj = get_post_type_object( $this->post_type );

		if ( ! $post_obj->rewrite ) {
			return;
		}

		$pretty_pattern = '%s/([^/]+)/%s/?$';
		$real_pattern   = 'index.php?%s=$matches[1]&%s=%s';

		/**
		 * We are adding each subpage as its own rule so that the attachment
		 * rewrite rule continues to function as normal. The only side effect
		 * is that in a collision between an attachment and a subpage with the
		 * same slug, our subpages will win. Sorry not sorry.
		 */
		foreach ( $this->subpages as $subpage ) {
			if ( 'index' === $subpage->slug ) {
				continue;
			}

			add_rewrite_rule(
				sprintf( $pretty_pattern, $post_obj->rewrite['slug'], $subpage->slug ),
				sprintf( $real_pattern, $post_obj->query_var, $this->query_var, $subpage->slug ),
				'top' // supercede the attachment rewrite rule
			);
		}
	}

	/**
	 * Updates the 'title' document title part for Subpages.
	 *
	 * Called on filter: `document_title_parts`
	 *
	 * @since 0.1.0
	 *
	 * @param array $title The current title parts.
	 * @return array $title The potentially filtered
	 */
	public function maybe_update_title( array $title ): array {
		if ( is_singular( $this->post_type ) ) {
			$subpage = $this->get_active_subpage( 'object' );

			if ( $subpage && 'index' !== $subpage->slug ) {
				/**
				 * Filters the 'title' part of document_title_part for subpages.
				 *
				 * @since 0.1
				 *
				 * @param string $title_part The resulting 'title' part.
				 * @param string $subpage_doc_title The document_title property of the subpage.
				 * @param string $current_title The original 'title' part for the parent post.
				 * @param Subpage $subpage The current/active Subpage object.
				 * @param array $title_parts The complete title parts from `document_title_parts` filter.
				 */
				$title['title'] = apply_filters(
					'pdl/subpage_document_title_part',
					$subpage->document_title . ', ' . $title['title'],
					$subpage->document_title,
					$title['title'],
					$subpage,
					$title
				);

				return $title;
			}
		}

		return $title;
	}

	/**
	 * Decides whether or not to override the canonical tag.
	 *
	 * Called on action: `wp`
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function maybe_override_rel_canonical(): void {
		if ( is_singular( $this->post_type ) && $this->get_active_subpage() !== 'index' ) {
			remove_filter( 'wp_head', 'rel_canonical' );
			add_filter( 'wp_head', [ &$this, 'subpage_canonical' ] );
		}
	}

	/**
	 * Renders a custom canonical link for subpages.
	 *
	 * Called on filter: `wp_head`
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function subpage_canonical(): void {
		printf(
			'<link rel="canonical" href="%s" />',
			esc_url( self::get_subpage_link( $this->get_active_subpage(), false ) )
		);
	}

	/**
	 * Returns the active subpage.
	 *
	 * This function should only be called in the context of a single post
	 * matching the current post_type.
	 *
	 * @since 0.1.0
	 *
	 * @param string $return_type The format of the returned subpage. Either 'slug' or 'object'. Defaults to 'slug'.
	 * @return mixed The active subpage, either slug or the full object. False if active page not found.
	 */
	public function get_active_subpage( string $return_type = 'slug' ) {
		$slug = get_query_var( $this->query_var );

		$slug = $slug ? $slug : 'index';

		if ( 'slug' === $return_type ) {
			return $slug;
		}

		if ( 'object' !== $return_type ) {
			return false;
		}

		if ( ! $this->active_subpage ) {
			$this->active_subpage = $this->get_subpage( $slug );
		}

		return $this->active_subpage;
	}

	/**
	 * Tests whether the subpage is currently active.
	 *
	 * @since 0.1.0
	 *
	 * @param string $subpage The slug of the subpage to test.
	 * @return boolean
	 */
	public function is_active_subpage( string $subpage ): bool {
		return $subpage === $this->get_active_subpage();
	}

	/**
	 * Retrieves a {@see \PedalCMS\Core\Subpage} object from the list of
	 * registered subpages.
	 *
	 * If supplied a Subpage object, it will simply return it whether or not
	 * the subpage has been registered. Caveat emptor.
	 *
	 * @since 0.1.0
	 *
	 * @param mixed $subpage Either a string slug of a subpage or a {@see \PedalCMS\Core\Subpage} object.
	 * @param boolean $search_builtin Whether or no to include builtin subpages which may be disabled. Defaults to false.
	 * @return mixed A Subpage object on success, WP_Error on failure.
	 */
	public function get_subpage( $subpage, $search_builtin = false ) {
		if ( $subpage instanceof Subpage ) {
			return $subpage;
		} elseif ( is_string( $subpage ) ) {
			$i = array_search(
				$subpage,
				wp_list_pluck( $this->subpages, 'slug' ),
				true
			);

			if ( false !== $i ) {
				return $this->subpages[ $i ];
			}

			if ( $search_builtin ) {
				$i = array_search(
					$subpage,
					wp_list_pluck( $this->builtin, 'slug' ),
					true
				);

				if ( false !== $i ) {
					return $this->builtin[ $i ];
				}
			}

			$error = 'Subpage not found.';
		} else {
			$error = gettype( $subpage ) . ' type is not allowed.';
		}

		return new \WP_Error(
			'error',
			$error,
			$subpage
		);
	}


	/**
	 * Determines whether a particular subpage should be rendered.
	 *
	 * @since 0.1.0
	 *
	 * @param mixed $subpage Either a PedalCMS\Core\Subpage or the slug of one.
	 * @return boolean
	 */
	public function maybe_show_subpage( $subpage ): bool {
		$subpage = $this->get_subpage( $subpage );

		if ( is_wp_error( $subpage ) ) {
			return false;
		}

		$show = true;

		if ( 'index' !== $subpage->slug && $subpage->is_builtin() ) {
			$field_safe = str_replace( '-', '_', $subpage->slug );

			$show = (bool) get_field( sprintf( 'show_%s_section', $field_safe ) );
		}

		/**
		 * Filters the decision to show a particular subpage.
		 *
		 * @since 0.1.0
		 *
		 * @param bool $show_subpage Whether to show the subpage.
		 * @param string $subpage The subpage in question.
		 * @param string $post_type The post_type this subpage belongs to.
		 */
		return apply_filters( 'pdl/maybe_show_subpage', $show, $subpage, $this->post_type );
	}

	/**
	 * Gets the list of currently enabled subpages.
	 *
	 * The order of these should _not_ be trusted.
	 *
	 * @since 0.1.0
	 *
	 * @return array List of subpages by slug.
	 */
	public function get_enabled_subpages(): array {
		// TODO: Make this dynamic based on post type.
		$enabled = get_option( 'options_pdl_enable_subpages_' . $this->post_type );

		if ( ! is_array( $enabled ) ) {
			$enabled = [];
		}

		/**
		 * Filters the list of currently enabled subpages.
		 *
		 * @since 0.1
		 *
		 * @param array $filters The subpages by slug.
		 */
		return apply_filters( 'pdl/enabled_subpages', $enabled, $this->post_type, $this->subpages );
	}

	/**
	 * Generates a URL for a given subpage.
	 *
	 * This function should only be called in the context of a single post
	 * matching the current post_type.
	 *
	 * @since 0.1.0
	 *
	 * @param string $subpage The slug of the subpage.
	 * @param boolean $output Whether or not to output the URL.
	 * @return string The subpage URL.
	 */
	public static function get_subpage_link( string $subpage, bool $output = true ): string {
		$link = 'index' === $subpage ?
			get_the_permalink() :
			sprintf( '%s%s/', get_the_permalink(), $subpage );

		/**
		 * Filters the subpage link.
		 *
		 * @since 0.1.0
		 *
		 * @param string $url The url of the subpage.
		 * @param string $subpage The slug of the corresponding subpage.
		 */
		$link = apply_filters( 'pdl/get_subpage_link', $link, $subpage );

		if ( $output ) {
			echo esc_url( $link );
		}

		return $link;
	}

	/**
	 * Returns a list of ACF fields from all enabled subpages.
	 *
	 * @since 0.1.0
	 *
	 * @return array List of ACF fields.
	 */
	public function get_enabled_subpage_fields(): array {
		$fields = [];

		foreach ( $this->subpages as $subpage ) {
			if ( ! empty( $subpage->fields ) ) {
				$fields[] = [
					'key'       => sprintf( 'field_%s_%s', $this->post_type, $subpage->slug ),
					'label'     => $subpage->tab_label,
					'type'      => 'tab',
					'placement' => 'top',
					'endpoint'  => 0,
				];
				$fields   = array_merge( $fields, $subpage->fields );
			}
		}

		return $fields;
	}
}
