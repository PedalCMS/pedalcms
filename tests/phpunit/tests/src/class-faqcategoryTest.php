<?php

namespace PedalCMS\Tests;

class ClassFaqCategoryTest extends FeatureTestCase {
public function test_faq_category_class_exists(): void {
$this->assertTrue( class_exists( \PedalCMS\Core\FAQCategory::class ) );
}

public function test_faq_category_singleton_returns_instance(): void {
$this->assertInstanceOf( \PedalCMS\Core\FAQCategory::class, \PedalCMS\Core\FAQCategory::get_instance() );
}
}
