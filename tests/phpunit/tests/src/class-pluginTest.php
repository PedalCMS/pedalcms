<?php

namespace PedalCMS\Tests;

/**
 * Mirrors src/class-plugin.php behaviors.
 *
 * @package PedalCMS
 */
class ClassPluginTest extends FeatureTestCase {

	/**
	 * Verifies get_option reads persisted option values.
	 */
	public function test_get_option_returns_saved_value(): void {
		$this->set_plugin_option( 'presentation_mode', 'full' );

		$this->assertSame( 'full', \PedalCMS\Core\Plugin::get_option( 'presentation_mode' ) );
	}

	/**
	 * Verifies get_option returns fallback when option does not exist.
	 */
	public function test_get_option_returns_fallback_when_missing(): void {
		$this->delete_plugin_option( 'not_a_real_setting' );

		$this->assertSame( 'fallback', \PedalCMS\Core\Plugin::get_option( 'not_a_real_setting', 'fallback' ) );
	}

	/**
	 * Verifies get_option applies both global and per-option filters.
	 */
	public function test_get_option_applies_filters(): void {
		$global_filter = static function ( $value, string $option ) {
			if ( 'presentation_mode' === $option ) {
				return 'base';
			}

			return $value;
		};

		$option_filter = static function ( $value ) {
			return strtoupper( (string) $value );
		};

		add_filter( 'pdl/options/all', $global_filter, 10, 2 );
		add_filter( 'pdl/options/presentation_mode', $option_filter );

		$this->set_plugin_option( 'presentation_mode', 'none' );
		$this->assertSame( 'BASE', \PedalCMS\Core\Plugin::get_option( 'presentation_mode' ) );

		remove_filter( 'pdl/options/all', $global_filter, 10 );
		remove_filter( 'pdl/options/presentation_mode', $option_filter );
	}

	/**
	 * Verifies custom blocks register when personnel block editor mode is enabled.
	 */
	public function test_register_custom_blocks_when_enabled(): void {
		$registry = \WP_Block_Type_Registry::get_instance();

		if ( ! $registry->is_registered( 'pdl/contact-info' ) || ! $registry->is_registered( 'pdl/job-title' ) ) {
			$this->set_plugin_option( 'enable_block_editor_personnel', 1 );
			\PedalCMS\Core\Plugin::register_custom_blocks();
		}

		$this->assertTrue( $registry->is_registered( 'pdl/contact-info' ) );
		$this->assertTrue( $registry->is_registered( 'pdl/job-title' ) );
	}
}
