<?php

namespace PedalCMS\Tests;

class ClassPersonCategoryTest extends FeatureTestCase {
	public function test_person_category_class_exists(): void {
		$this->assertTrue( class_exists( \PedalCMS\Core\PersonCategory::class ) );
	}

	public function test_person_category_singleton_returns_instance(): void {
		$this->assertInstanceOf( \PedalCMS\Core\PersonCategory::class, \PedalCMS\Core\PersonCategory::get_instance() );
	}
}
