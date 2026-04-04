<?php

namespace PedalCMS\Tests;

class ClassSubpageManagerTest extends FeatureTestCase {
	public function test_subpage_manager_class_exists(): void {
		$this->assertTrue( class_exists( \PedalCMS\Core\SubpageManager::class ) );
	}

	public function test_subpage_manager_add_query_var_registers_var(): void {
		$manager = new \PedalCMS\Core\SubpageManager( 'pdl_program' );
		$result  = $manager->add_query_var( [] );

		$this->assertContains( 'pdl_subpage', $result );
	}
}
