<?php

namespace PedalCMS\Tests;

class ClassJobTitleBlockTest extends FeatureTestCase {
public function test_job_title_block_class_exists(): void {
$this->assertTrue( class_exists( \PedalCMS\Core\JobTitleBlock::class ) );
}
}
