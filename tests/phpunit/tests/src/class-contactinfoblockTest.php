<?php

namespace PedalCMS\Tests;

class ClassContactInfoBlockTest extends FeatureTestCase {
public function test_contact_info_block_class_exists(): void {
$this->assertTrue( class_exists( \PedalCMS\Core\ContactInfoBlock::class ) );
}
}
