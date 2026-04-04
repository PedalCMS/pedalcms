<?php

namespace PedalCMS\Tests;

class ClassRelationshipFieldTest extends FeatureTestCase {
	public function test_relationship_field_class_exists(): void {
		$this->assertTrue( class_exists( \PedalCMS\Fields\Relationship_Field::class ) );
	}

	public function test_relationship_field_parent_class(): void {
		$this->assertSame( \Pedalcms\CassetteCmf\Field\Abstract_Field::class, get_parent_class( \PedalCMS\Fields\Relationship_Field::class ) );
	}
}
