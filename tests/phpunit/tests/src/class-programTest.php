<?php

namespace PedalCMS\Tests;

/**
 * Mirrors src/class-program.php behaviors.
 *
 * @package PedalCMS
 */
class ClassProgramTest extends FeatureTestCase {

	/**
	 * Verifies Program is exposed in WordPress REST API.
	 */
	public function test_program_post_type_rest_integration(): void {
		$post_type = get_post_type_object( \PedalCMS\Core\Program::POST_TYPE );

		$this->assertNotNull( $post_type );
		$this->assertTrue( (bool) $post_type->show_in_rest );
		$this->assertSame( 'programs', $post_type->rest_base );

		do_action( 'rest_api_init' );
		$routes = rest_get_server()->get_routes();

		$this->assertArrayHasKey( '/wp/v2/programs', $routes );
	}

	/**
	 * Verifies action links resolve placeholders from global option patterns.
	 */
	public function test_program_action_link_uses_global_pattern_placeholders(): void {
		$post_id = $this->factory->post->create(
			[
				'post_type' => 'pdl_program',
				'post_name' => 'nursing-program',
			]
		);

		update_post_meta( $post_id, 'program_guid', 'GUID-100' );
		$this->set_plugin_option( 'program_url_apply_now', 'https://apply.example.edu/{$program_guid}/{$program_slug}' );

		$url = \PedalCMS\Core\Program::get_action_link( 'apply_now', $post_id );

		$this->assertSame( 'https://apply.example.edu/GUID-100/nursing-program', $url );
	}

	/**
	 * Verifies local URL overrides take precedence over global action URLs.
	 */
	public function test_program_action_link_prefers_local_override(): void {
		$post_id = $this->factory->post->create(
			[
				'post_type' => 'pdl_program',
			]
		);

		update_post_meta( $post_id, 'url_apply_now', 'https://local.example.edu/apply-now' );
		$this->set_plugin_option( 'program_url_apply_now', 'https://global.example.edu/{$program_guid}' );

		$url = \PedalCMS\Core\Program::get_action_link( 'apply_now', $post_id );

		$this->assertSame( 'https://local.example.edu/apply-now', $url );
	}

	/**
	 * Verifies program deadlines fall back to global settings when no overrides exist.
	 */
	public function test_program_application_deadlines_fallback_to_global_option(): void {
		$post_id   = $this->factory->post->create(
			[
				'post_type' => 'pdl_program',
			]
		);
		$deadlines = [
			[
				'label' => 'Fall',
				'info'  => 'June 1',
			],
			[
				'label' => 'Spring',
				'info'  => 'October 15',
			],
		];

		$this->set_plugin_option( 'program_application_deadlines', $deadlines );

		$this->assertSame( $deadlines, \PedalCMS\Core\Program::get_application_deadlines( $post_id ) );
	}
}
