<?php

namespace PedalCMS\Tests;

/**
 * Mirrors src/class-department.php behaviors.
 *
 * @package PedalCMS
 */
class ClassDepartmentTest extends FeatureTestCase {

	/**
	 * Verifies Department dependency requires both college and dependency toggles.
	 */
	public function test_department_depends_on_college_requires_both_options(): void {
		$this->set_plugin_option( 'college_enable', 1 );
		$this->set_plugin_option( 'department_depends_college', 1 );
		$this->assertTrue( \PedalCMS\Core\Department::depends_on_college() );

		$this->set_plugin_option( 'department_depends_college', 0 );
		$this->assertFalse( \PedalCMS\Core\Department::depends_on_college() );
	}
}
