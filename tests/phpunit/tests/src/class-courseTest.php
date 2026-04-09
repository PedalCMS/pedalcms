<?php

namespace PedalCMS\Tests;

class ClassCourseTest extends FeatureTestCase {
	public function test_course_class_exists(): void {
		$this->assertTrue( class_exists( \PedalCMS\Core\Course::class ) );
	}

	public function test_course_singleton_returns_course_instance(): void {
		$this->assertInstanceOf( \PedalCMS\Core\Course::class, \PedalCMS\Core\Course::get_instance() );
	}

	public function test_course_post_type_is_not_rest_enabled_by_default(): void {
		if ( post_type_exists( \PedalCMS\Core\Course::POST_TYPE ) && function_exists( 'unregister_post_type' ) ) {
			unregister_post_type( \PedalCMS\Core\Course::POST_TYPE );
		}

		\PedalCMS\Core\Course::get_instance()->register();
		$post_type = get_post_type_object( \PedalCMS\Core\Course::POST_TYPE );

		$this->assertNotNull( $post_type );
		$this->assertFalse( (bool) $post_type->show_in_rest );

		do_action( 'rest_api_init' );
		$routes = rest_get_server()->get_routes();

		$this->assertArrayNotHasKey( '/wp/v2/pdl_course', $routes );
	}
}
