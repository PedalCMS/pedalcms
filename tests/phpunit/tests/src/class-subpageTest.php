<?php

namespace PedalCMS\Tests;

class ClassSubpageTest extends FeatureTestCase {
	public function test_subpage_class_exists(): void {
		$this->assertTrue( class_exists( \PedalCMS\Core\Subpage::class ) );
	}

	public function test_subpage_label_fallbacks_use_title(): void {
		$subpage = new \PedalCMS\Core\Subpage( 'news-item' );
		$subpage->before_add();

		$this->assertSame( 'News Item', $subpage->title );
		$this->assertSame( 'News Item', $subpage->tab_label );
		$this->assertSame( 'News Item', $subpage->document_title );
	}
}
