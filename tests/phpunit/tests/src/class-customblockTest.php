<?php

namespace PedalCMS\Tests;

class ClassCustomBlockTest extends FeatureTestCase {
public function test_custom_block_class_exists(): void {
$this->assertTrue( class_exists( \PedalCMS\Core\CustomBlock::class ) );
}

public function test_custom_block_is_abstract(): void {
$this->assertTrue( ( new \ReflectionClass( \PedalCMS\Core\CustomBlock::class ) )->isAbstract() );
}
}
