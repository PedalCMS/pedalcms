<?php

namespace PedalCMS\Tests;

class ClassInstructionModeTest extends FeatureTestCase {
public function test_instruction_mode_class_exists(): void {
$this->assertTrue( class_exists( \PedalCMS\Core\InstructionMode::class ) );
}

public function test_instruction_mode_singleton_returns_instance(): void {
$this->assertInstanceOf( \PedalCMS\Core\InstructionMode::class, \PedalCMS\Core\InstructionMode::get_instance() );
}
}
