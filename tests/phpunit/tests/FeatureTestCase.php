<?php

namespace PedalCMS\Tests;

use WP_UnitTestCase;

/**
 * Shared helpers for option-driven feature tests.
 *
 * @package PedalCMS
 */
abstract class FeatureTestCase extends WP_UnitTestCase {

	/**
	 * Tracks option names touched by the test to clean up afterward.
	 *
	 * @var array<string, bool>
	 */
	private $touched_options = [];

	/**
	 * Persists a plugin option using the PedalCMS options prefix.
	 *
	 * @param string $option Option name without prefix.
	 * @param mixed  $value  Option value.
	 * @return void
	 */
	protected function set_plugin_option( string $option, $value ): void {
		$full_name                         = 'options_pdl_' . $option;
		$this->touched_options[ $full_name ] = true;
		update_option( $full_name, $value );
	}

	/**
	 * Deletes a plugin option using the PedalCMS options prefix.
	 *
	 * @param string $option Option name without prefix.
	 * @return void
	 */
	protected function delete_plugin_option( string $option ): void {
		$full_name                         = 'options_pdl_' . $option;
		$this->touched_options[ $full_name ] = true;
		delete_option( $full_name );
	}

	/**
	 * Resets test-side option state and query context.
	 *
	 * @return void
	 */
	public function tear_down(): void {
		foreach ( array_keys( $this->touched_options ) as $option_name ) {
			delete_option( $option_name );
		}

		unset( $_GET['post_type'] );
		set_query_var( 'post_type', null );
		set_query_var( 'taxonomy', null );
		set_query_var( 'term', null );

		parent::tear_down();
	}
}
