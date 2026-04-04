<?php

namespace PedalCMS\Tests;

class ClassProgramTypeTest extends FeatureTestCase {
	public function test_program_type_class_exists(): void {
		$this->assertTrue( class_exists( \PedalCMS\Core\ProgramType::class ) );
	}

	public function test_program_type_singleton_returns_instance(): void {
		$this->assertInstanceOf( \PedalCMS\Core\ProgramType::class, \PedalCMS\Core\ProgramType::get_instance() );
	}
}
