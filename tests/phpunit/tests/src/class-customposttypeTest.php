<?php

namespace PedalCMS\Tests;

class ClassCustomPostTypeTest extends FeatureTestCase {
public function test_custom_post_type_class_exists(): void {
$this->assertTrue( class_exists( \PedalCMS\Core\CustomPostType::class ) );
}

public function test_custom_post_type_is_abstract(): void {
$this->assertTrue( ( new \ReflectionClass( \PedalCMS\Core\CustomPostType::class ) )->isAbstract() );
}
}
