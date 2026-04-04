<?php

namespace PedalCMS\Tests;

class ClassSessionTest extends FeatureTestCase {
	public function test_session_class_exists(): void {
		$this->assertTrue( class_exists( \PedalCMS\Core\Session::class ) );
	}

	public function test_session_singleton_returns_instance(): void {
		$this->assertInstanceOf( \PedalCMS\Core\Session::class, \PedalCMS\Core\Session::get_instance() );
	}
}
