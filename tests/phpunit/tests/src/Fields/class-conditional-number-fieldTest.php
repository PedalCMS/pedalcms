<?php

namespace PedalCMS\Tests;

class ClassConditionalNumberFieldTest extends FeatureTestCase {
	public function test_conditional_number_field_class_exists(): void {
		$this->assertTrue( class_exists( \PedalCMS\Fields\Conditional_Number_Field::class ) );
	}

	public function test_conditional_number_field_parent_class(): void {
		$this->assertSame( \Pedalcms\CassetteCmf\Field\Fields\Number_Field::class, get_parent_class( \PedalCMS\Fields\Conditional_Number_Field::class ) );
	}
}
