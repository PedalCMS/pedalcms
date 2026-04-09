<?php

namespace PedalCMS\Tests;

class ClassTemplateManagerTest extends FeatureTestCase {
	public function test_template_manager_class_exists(): void {
		$this->assertTrue( class_exists( \PedalCMS\Core\TemplateManager::class ) );
	}

	public function test_convert_obj_name_to_template_returns_slug(): void {
		$this->assertSame( 'program-type', \PedalCMS\Core\TemplateManager::convert_obj_name_to_template( 'pdl_program_type' ) );
	}
}
