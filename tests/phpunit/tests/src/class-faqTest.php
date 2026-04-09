<?php

namespace PedalCMS\Tests;

class ClassFaqTest extends FeatureTestCase {
public function test_faq_class_exists(): void {
$this->assertTrue( class_exists( \PedalCMS\Core\FAQ::class ) );
}

public function test_faq_singleton_returns_instance(): void {
$this->assertInstanceOf( \PedalCMS\Core\FAQ::class, \PedalCMS\Core\FAQ::get_instance() );
}
}
