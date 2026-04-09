<?php

namespace PedalCMS\Tests;

class ClassCustomContentObjectTest extends FeatureTestCase {
public function test_custom_content_object_class_exists(): void {
$this->assertTrue( class_exists( \PedalCMS\Core\CustomContentObject::class ) );
}

public function test_custom_content_object_is_abstract(): void {
$this->assertTrue( ( new \ReflectionClass( \PedalCMS\Core\CustomContentObject::class ) )->isAbstract() );
}
}
