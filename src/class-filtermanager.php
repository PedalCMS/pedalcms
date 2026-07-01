<?php

namespace PedalCMS\Core;

use WP_Query;

/**
 * A reusable registry for post-type archive filters.
 *
 * Plugins register a filter with a slug, label, query var, a way to render its
 * control (template or callback), and a callback that constrains the archive
 * query. Modeled on {@see SubpageManager}.
 *
 * @since 0.1.0
 */
class FilterManager {
	/**
	 * The singleton instance.
	 *
	 * @var FilterManager|null
	 */
	private static ?FilterManager $instance = null;

	/**
	 * Registered filter definitions, keyed by slug.
	 *
	 * @var array<string, array>
	 */
	private array $filters = [];

	private function __construct() {
		$this->setup_hooks();
	}

	/**
	 * Returns the shared instance.
	 */
	public static function get_instance(): FilterManager {
		if ( ! self::$instance instanceof FilterManager ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function setup_hooks(): void {
		add_filter( 'query_vars', [ $this, 'add_query_vars' ], 5 );
		add_action( 'pdl/after_filters_fields', [ $this, 'render_filters' ], 20, 1 );
		add_action( 'pre_get_posts', [ $this, 'apply_filters_to_query' ] );
	}

	/**
	 * Registers a filter.
	 *
	 * Recognized $args keys:
	 *  - 'label'     (string)          Human-readable control label.
	 *  - 'post_type' (string|string[]) Post type(s) the filter applies to.
	 *  - 'query_var' (string)          Request var; defaults to the slug.
	 *  - 'template'  (string)          Template part rendering the control.
	 *  - 'render'    (callable)        Renders the control, given a context array.
	 *  - 'apply'     (callable)        fn(WP_Query $query, string $value): void.
	 *  - 'order'     (int)             Sort order among registered filters.
	 *
	 * @return array|\WP_Error The stored definition, or WP_Error on invalid input.
	 */
	public function register( string $slug, array $args = [] ) {
		$slug = sanitize_key( $slug );

		if ( '' === $slug ) {
			return new \WP_Error( 'error', 'A filter slug is required.' );
		}

		$definition = wp_parse_args(
			$args,
			[
				'slug'      => $slug,
				'label'     => '',
				'post_type' => [],
				'query_var' => $slug,
				'template'  => '',
				'render'    => null,
				'apply'     => null,
				'order'     => 10,
			]
		);

		$definition['slug']      = $slug;
		$definition['post_type'] = array_filter( (array) $definition['post_type'] );

		$this->filters[ $slug ] = $definition;

		uasort(
			$this->filters,
			static fn( array $a, array $b ): int => $a['order'] <=> $b['order']
		);

		return $definition;
	}

	/**
	 * Returns registered filters that apply to the given post type.
	 *
	 * @return array<string, array>
	 */
	public function get_for_post_type( string $post_type ): array {
		return array_filter(
			$this->filters,
			static fn( array $filter ): bool => empty( $filter['post_type'] ) || in_array( $post_type, $filter['post_type'], true )
		);
	}

	/**
	 * Registers each filter's query var so WordPress preserves it.
	 *
	 * @param array $vars Existing public query vars.
	 * @return array
	 */
	public function add_query_vars( array $vars ): array {
		foreach ( $this->filters as $filter ) {
			$vars[] = $filter['query_var'];
		}

		return $vars;
	}

	/**
	 * Renders registered filter controls after the built-in filter fields.
	 *
	 * Called on action: `pdl/after_filters_fields`.
	 *
	 * @param array $args The filter template args (includes 'post_type').
	 */
	public function render_filters( array $args ): void {
		$post_type = $args['post_type'] ?? '';

		if ( ! $post_type ) {
			return;
		}

		foreach ( $this->get_for_post_type( $post_type ) as $filter ) {
			$context = [
				'filter'    => $filter,
				'post_type' => $post_type,
				'label'     => $filter['label'],
				'query_var' => $filter['query_var'],
				'value'     => $this->get_request_value( $filter['query_var'] ),
			];

			if ( is_callable( $filter['render'] ) ) {
				call_user_func( $filter['render'], $context );
			} elseif ( $filter['template'] ) {
				pdl_get_template_part( $filter['template'], $context );
			}
		}
	}

	/**
	 * Applies registered filters to the main archive query.
	 *
	 * Called on action: `pre_get_posts`.
	 */
	public function apply_filters_to_query( WP_Query $query ): void {
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		foreach ( $this->filters as $filter ) {
			if ( ! is_callable( $filter['apply'] ) ) {
				continue;
			}

			if ( ! empty( $filter['post_type'] ) && ! $query->is_post_type_archive( $filter['post_type'] ) ) {
				continue;
			}

			$value = $this->get_request_value( $filter['query_var'] );

			if ( '' === $value ) {
				continue;
			}

			call_user_func( $filter['apply'], $query, $value );
		}
	}

	/**
	 * Reads and sanitizes a filter value from the request.
	 */
	private function get_request_value( string $query_var ): string {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Public archive filter read from the query string.
		return isset( $_GET[ $query_var ] ) ? sanitize_text_field( wp_unslash( $_GET[ $query_var ] ) ) : '';
	}
}
