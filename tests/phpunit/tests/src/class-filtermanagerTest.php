<?php

namespace PedalCMS\Tests;

use PedalCMS\Core\FilterManager;
use WP_Query;

class ClassFilterManagerTest extends FeatureTestCase {
	public function test_filter_manager_class_exists(): void {
		$this->assertTrue( class_exists( FilterManager::class ) );
	}

	public function test_register_scopes_filters_by_post_type(): void {
		$manager = FilterManager::get_instance();

		$manager->register(
			'test_program_filter',
			[
				'label'     => 'Program Filter',
				'post_type' => 'pdl_program',
				'query_var' => 'test_program_filter',
			]
		);

		$program_filters = $manager->get_for_post_type( 'pdl_program' );
		$course_filters  = $manager->get_for_post_type( 'pdl_course' );

		$this->assertArrayHasKey( 'test_program_filter', $program_filters );
		$this->assertArrayNotHasKey( 'test_program_filter', $course_filters );
	}

	public function test_add_query_vars_registers_each_query_var(): void {
		$manager = FilterManager::get_instance();

		$manager->register(
			'test_qv_filter',
			[
				'post_type' => 'pdl_program',
				'query_var' => 'test_qv',
			]
		);

		$this->assertContains( 'test_qv', $manager->add_query_vars( [] ) );
	}

	public function test_apply_filters_to_query_invokes_matching_apply_callback(): void {
		$manager  = FilterManager::get_instance();
		$captured = null;

		$manager->register(
			'test_apply_filter',
			[
				'post_type' => 'pdl_program',
				'query_var' => 'test_apply',
				'apply'     => function ( $query, $value ) use ( &$captured ) {
					$captured = $value;
				},
			]
		);

		$_GET['test_apply'] = 'blue';

		$query                       = new WP_Query( [ 'post_type' => 'pdl_program' ] );
		$query->is_post_type_archive = true;
		$query->is_archive           = true;
		$GLOBALS['wp_the_query']     = $query;

		$manager->apply_filters_to_query( $query );

		unset( $_GET['test_apply'] );

		$this->assertSame( 'blue', $captured );
	}

	public function test_apply_filters_to_query_ignores_other_post_types(): void {
		$manager = FilterManager::get_instance();
		$called  = false;

		$manager->register(
			'test_scope_filter',
			[
				'post_type' => 'pdl_course',
				'query_var' => 'test_scope',
				'apply'     => function () use ( &$called ) {
					$called = true;
				},
			]
		);

		$_GET['test_scope'] = 'x';

		$query                       = new WP_Query( [ 'post_type' => 'pdl_program' ] );
		$query->is_post_type_archive = true;
		$query->is_archive           = true;
		$GLOBALS['wp_the_query']     = $query;

		$manager->apply_filters_to_query( $query );

		unset( $_GET['test_scope'] );

		$this->assertFalse( $called );
	}
}
