<?php
/**
 * Polyfill shims for ACF-style field accessor functions.
 *
 * Defines get_field() and the_field() in the global namespace when ACF (or any
 * other implementation) has not already declared them. Values are read directly
 * from the native WordPress meta storage that CassetteCMF writes to.
 *
 * Execution is deferred to plugins_loaded priority 1 so that a standalone ACF
 * plugin, if present, always wins — it will have defined get_field() before our
 * callback runs and the function_exists() guard will skip this shim.
 *
 * Supported $post_id formats (mirrors ACF's own signature):
 *   false / null / 0   → current post in the loop (get_the_ID())
 *   WP_Post            → post meta on that object
 *   WP_Term            → term meta on that object
 *   positive int       → post meta for that post ID
 *   'term_<n>'         → term meta for term ID n (ACF's term-ID string format)
 *   'option'/'options' → plugin option stored by CassetteCMF settings page
 *
 * @package PedalCMS
 * @since 0.3.0
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'plugins_loaded',
	static function (): void {
		if ( function_exists( 'get_field' ) ) {
			return;
		}

		/**
		 * Reads a CassetteCMF-managed field value from native WP storage.
		 *
		 * @param string $selector     The field / meta key.
		 * @param mixed  $post_id      Object context — see file-level docs.
		 * @param bool   $format_value Ignored; kept for ACF signature compat.
		 * @return mixed The stored value, or false when nothing is found.
		 */
		function get_field( string $selector, $post_id = false, bool $format_value = true ): mixed {
			// Options / settings page.
			if ( $post_id === 'option' || $post_id === 'options' ) {
				return get_option( 'options_pdl_' . $selector );
			}

			// WP_Term object.
			if ( $post_id instanceof \WP_Term ) {
				return get_term_meta( $post_id->term_id, $selector, true );
			}

			// WP_Post object.
			if ( $post_id instanceof \WP_Post ) {
				return get_post_meta( $post_id->ID, $selector, true );
			}

			// ACF 'term_<id>' string format.
			if ( is_string( $post_id ) && str_starts_with( $post_id, 'term_' ) ) {
				$term_id = (int) substr( $post_id, 5 );
				return $term_id ? get_term_meta( $term_id, $selector, true ) : false;
			}

			// Explicit numeric post ID.
			$post_id = (int) $post_id;
			if ( $post_id > 0 ) {
				return get_post_meta( $post_id, $selector, true );
			}

			// Default: current post in The Loop.
			$current_id = get_the_ID();
			return $current_id ? get_post_meta( $current_id, $selector, true ) : false;
		}

		/**
		 * Echoes a CassetteCMF-managed field value (mirrors ACF's the_field()).
		 *
		 * @param string $selector The field / meta key.
		 * @param mixed  $post_id  Object context — see get_field() docs.
		 * @return void
		 */
		function the_field( string $selector, $post_id = false ): void {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo get_field( $selector, $post_id );
		}
	},
	1
);
