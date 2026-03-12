<?php
/**
 * Conditional_Checkbox_Field - CassetteCMF custom field type.
 *
 * A single checkbox that shows or hides other fields based on its state.
 * Extends CassetteCMF's built-in Checkbox_Field and adds a
 * `data-conditional-toggle` HTML attribute to its wrapper.
 *
 * Configuration options (in addition to Checkbox_Field's own):
 * - conditional: (string|string[]) One or more field names to show/hide.
 *
 * @package PedalCMS\Fields
 * @since 0.3.0
 */

namespace PedalCMS\Fields;

use Pedalcms\CassetteCmf\Field\Fields\Checkbox_Field;

/**
 * Conditional_Checkbox_Field class
 */
class Conditional_Checkbox_Field extends Checkbox_Field {

	/**
	 * Get field type defaults.
	 *
	 * @return array<string, mixed>
	 */
	protected function get_defaults(): array {
		return array_merge(
			parent::get_defaults(),
			[
				'conditional' => [],
			]
		);
	}

	/**
	 * Render wrapper start with optional data-conditional-toggle attribute.
	 *
	 * @return string
	 */
	protected function render_wrapper_start(): string {
		$targets = $this->config['conditional'] ?? [];

		if ( empty( $targets ) ) {
			return parent::render_wrapper_start();
		}

		if ( is_string( $targets ) ) {
			$targets = [ $targets ];
		}

		$classes = [ 'cassette-cmf-field', 'cassette-cmf-field-' . $this->type ];

		if ( ! empty( $this->config['class'] ) ) {
			$classes[] = $this->config['class'];
		}

		if ( ! empty( $this->config['required'] ) ) {
			$classes[] = 'cassette-cmf-field-required';
		}

		return sprintf(
			'<div class="%s" data-field-name="%s" data-field-type="%s" data-conditional-toggle="%s">',
			$this->esc_attr( implode( ' ', $classes ) ),
			$this->esc_attr( $this->name ),
			$this->esc_attr( $this->type ),
			$this->esc_attr( implode( ',', $targets ) )
		);
	}
}
