<?php
/**
 * Conditional_Number_Field — number field with show_if support.
 *
 * Extends CassetteCMF's Number_Field. When a `show_if` config is
 * provided, the wrapper gains a `data-pdl-show-if` attribute so
 * the client-side JS can toggle visibility based on another field's value.
 *
 * @package PedalCMS\Fields
 * @since 0.3.0
 */

namespace PedalCMS\Fields;

use Pedalcms\CassetteCmf\Field\Fields\Number_Field;

/**
 * Conditional_Number_Field class
 */
class Conditional_Number_Field extends Number_Field {

	/**
	 * Get field type defaults.
	 *
	 * @return array<string, mixed>
	 */
	protected function get_defaults(): array {
		return array_merge(
			parent::get_defaults(),
			[
				'show_if' => [],
			]
		);
	}

	/**
	 * Render wrapper start with data-pdl-show-if attribute when show_if is set.
	 *
	 * @return string
	 */
	protected function render_wrapper_start(): string {
		$html    = parent::render_wrapper_start();
		$show_if = $this->config['show_if'] ?? [];

		if ( empty( $show_if ) ) {
			return $html;
		}

		$attr = sprintf( ' data-pdl-show-if=\'%s\'', wp_json_encode( $show_if ) );

		return substr_replace( $html, $attr, -1, 0 );
	}
}
