<?php

namespace PedalCMS\Tests;

class ClassConditionalCheckboxFieldTest extends FeatureTestCase {
	public function test_conditional_checkbox_field_class_exists(): void {
		$this->assertTrue( class_exists( \PedalCMS\Fields\Conditional_Checkbox_Field::class ) );
	}

	public function test_conditional_checkbox_field_parent_class(): void {
		$this->assertSame( \Pedalcms\CassetteCmf\Field\Fields\Checkbox_Field::class, get_parent_class( \PedalCMS\Fields\Conditional_Checkbox_Field::class ) );
	}
}
