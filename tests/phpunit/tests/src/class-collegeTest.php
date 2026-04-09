<?php

namespace PedalCMS\Tests;

class ClassCollegeTest extends FeatureTestCase {
	public function test_college_class_exists(): void {
		$this->assertTrue( class_exists( \PedalCMS\Core\College::class ) );
	}

	public function test_college_singleton_returns_college_instance(): void {
		$this->assertInstanceOf( \PedalCMS\Core\College::class, \PedalCMS\Core\College::get_instance() );
	}

	public function test_college_taxonomy_is_not_rest_enabled_by_default(): void {
		if ( taxonomy_exists( \PedalCMS\Core\College::TAXONOMY ) && function_exists( 'unregister_taxonomy' ) ) {
			unregister_taxonomy( \PedalCMS\Core\College::TAXONOMY );
		}

		\PedalCMS\Core\College::get_instance()->register();
		$taxonomy = get_taxonomy( \PedalCMS\Core\College::TAXONOMY );

		$this->assertNotFalse( $taxonomy );
		$this->assertFalse( (bool) $taxonomy->show_in_rest );

		do_action( 'rest_api_init' );
		$routes = rest_get_server()->get_routes();

		$this->assertArrayNotHasKey( '/wp/v2/pdl_college', $routes );
	}
}
