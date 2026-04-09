<?php

namespace PedalCMS\Tests;

class ClassSubjectTest extends FeatureTestCase {
	public function test_subject_class_exists(): void {
		$this->assertTrue( class_exists( \PedalCMS\Core\Subject::class ) );
	}

	public function test_subject_singleton_returns_instance(): void {
		$this->assertInstanceOf( \PedalCMS\Core\Subject::class, \PedalCMS\Core\Subject::get_instance() );
	}
}
