<?php

namespace PedalCMS\Tests;

class ClassTaxonomyFieldTest extends FeatureTestCase {
	public function test_taxonomy_field_class_exists(): void {
		$this->assertTrue( class_exists( \PedalCMS\Fields\Taxonomy_Field::class ) );
	}

	public function test_taxonomy_field_parent_class(): void {
		$this->assertSame( \Pedalcms\CassetteCmf\Field\Abstract_Field::class, get_parent_class( \PedalCMS\Fields\Taxonomy_Field::class ) );
	}
}
