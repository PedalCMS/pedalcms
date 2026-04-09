<?php

namespace PedalCMS\Tests;

class ClassCustomTaxonomyTest extends FeatureTestCase {
public function test_custom_taxonomy_class_exists(): void {
$this->assertTrue( class_exists( \PedalCMS\Core\CustomTaxonomy::class ) );
}

public function test_custom_taxonomy_is_abstract(): void {
$this->assertTrue( ( new \ReflectionClass( \PedalCMS\Core\CustomTaxonomy::class ) )->isAbstract() );
}
}
