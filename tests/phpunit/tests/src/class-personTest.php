<?php

namespace PedalCMS\Tests;

/**
 * Mirrors src/class-person.php behaviors.
 *
 * @package PedalCMS
 */
class ClassPersonTest extends FeatureTestCase {

	/**
	 * Verifies Person can be registered with REST support when block editor is enabled.
	 */
	public function test_person_post_type_rest_integration_when_enabled(): void {
		$this->set_plugin_option( 'enable_block_editor_personnel', 1 );

		if ( post_type_exists( \PedalCMS\Core\Person::POST_TYPE ) && function_exists( 'unregister_post_type' ) ) {
			unregister_post_type( \PedalCMS\Core\Person::POST_TYPE );
		}

		\PedalCMS\Core\Person::get_instance()->register();
		$post_type = get_post_type_object( \PedalCMS\Core\Person::POST_TYPE );

		$this->assertNotNull( $post_type );
		$this->assertTrue( (bool) $post_type->show_in_rest );

		do_action( 'rest_api_init' );
		$routes = rest_get_server()->get_routes();

		$this->assertArrayHasKey( '/wp/v2/pdl_person', $routes );
	}

	/**
	 * Verifies Person block editor enable option controls helper behavior.
	 */
	public function test_person_block_editor_toggle_reflects_option(): void {
		$this->set_plugin_option( 'enable_block_editor_personnel', 1 );
		$this->assertTrue( \PedalCMS\Core\Person::is_block_editor_enabled() );

		$this->set_plugin_option( 'enable_block_editor_personnel', 0 );
		$this->assertFalse( \PedalCMS\Core\Person::is_block_editor_enabled() );
	}
}
