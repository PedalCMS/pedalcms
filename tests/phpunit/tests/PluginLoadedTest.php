<?php

namespace PedalCMS\Tests;

use WP_UnitTestCase;

/**
 * Smoke test — verifies the plugin bootstraps correctly.
 *
 * @package PedalCMS
 */
class PluginLoadedTest extends WP_UnitTestCase {

	/**
	 * The plugin file should be loaded and the constant AP_RUN_TESTS should be defined.
	 */
	public function test_plugin_constant_is_defined(): void {
		$this->assertTrue( defined( 'AP_RUN_TESTS' ) );
		$this->assertTrue( AP_RUN_TESTS );
	}

	/**
	 * The plugin's main class should be available.
	 */
	public function test_plugin_class_exists(): void {
		$this->assertTrue( class_exists( \PedalCMS\Core\Plugin::class ) );
	}

	/**
	 * Core custom post type classes should be autoloaded.
	 */
	public function test_core_cpt_classes_exist(): void {
		$this->assertTrue( class_exists( \PedalCMS\Core\CustomPostType::class ) );
		$this->assertTrue( class_exists( \PedalCMS\Core\CustomTaxonomy::class ) );
	}
}
