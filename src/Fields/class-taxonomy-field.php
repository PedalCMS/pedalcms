<?php
/**
 * Taxonomy_Field - CassetteCMF custom field type.
 *
 * Renders a select or radio field populated from a WordPress taxonomy.
 * Handles saving post terms when `save_terms` is true.
 *
 * @package PedalCMS\Fields
 * @since 0.3.0
 */

namespace PedalCMS\Fields;

use Pedalcms\CassetteCmf\Field\Abstract_Field;

/**
 * Taxonomy_Field class
 *
 * Configuration options:
 * - taxonomy:     (string, required) The taxonomy slug to pull terms from.
 * - field_type:   'select' (default) or 'radio' — controls the rendered input.
 * - multiple:     (bool) Allow multiple selections (select only). Default false.
 * - save_terms:   (bool) Whether to also set the object's taxonomy terms when
 *                 saving. Default false.
 * - placeholder:  (string) Placeholder for select. Default empty.
 * - all_label:    (string) Label for the empty "any" option. Default empty.
 */
class Taxonomy_Field extends Abstract_Field {

	/**
	 * Get field type defaults.
	 *
	 * @return array<string, mixed>
	 */
	protected function get_defaults(): array {
		return array_merge(
			parent::get_defaults(),
			[
				'taxonomy'   => '',
				'field_type' => 'select',
				'multiple'   => false,
				'save_terms' => false,
				'all_label'  => '',
			]
		);
	}

	/**
	 * Checks whether this taxonomy field should be hidden because its taxonomy
	 * is a PedalCMS-managed taxonomy that has been disabled in settings.
	 *
	 * @return bool True if the field should be suppressed.
	 */
	protected function is_taxonomy_disabled(): bool {
		$taxonomy = $this->config['taxonomy'] ?? '';

		// Only pdl_* taxonomies can be disabled via plugin settings.
		if ( ! $taxonomy || 0 !== strpos( $taxonomy, 'pdl_' ) ) {
			return false;
		}

		$option_key = str_replace( 'pdl_', '', $taxonomy ) . '_enable';
		$enabled    = \PedalCMS\Core\Plugin::get_option( $option_key );

		// false means option not found — treat as enabled.
		return false !== $enabled && ! $enabled;
	}

	/**
	 * Get terms for the configured taxonomy.
	 *
	 * @return \WP_Term[]
	 */
	protected function get_terms(): array {
		$taxonomy = $this->config['taxonomy'] ?? '';

		if ( ! $taxonomy || ! taxonomy_exists( $taxonomy ) ) {
			return [];
		}

		$terms = get_terms(
			[
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
			]
		);

		if ( is_wp_error( $terms ) ) {
			return [];
		}

		return $terms;
	}

	/**
	 * Build options array from taxonomy terms.
	 *
	 * @return array<int|string, string>
	 */
	protected function build_options(): array {
		$options   = [];
		$all_label = $this->config['all_label'] ?? '';

		if ( $all_label ) {
			$options[''] = esc_html( $all_label );
		}

		foreach ( $this->get_terms() as $term ) {
			$options[ $term->term_id ] = esc_html( $term->name );
		}

		return $options;
	}

	/**
	 * Render the taxonomy field.
	 *
	 * @param mixed $value Current value (term ID or array of term IDs).
	 * @return string HTML output.
	 */
	public function render( $value = null ): string {
		if ( $this->is_taxonomy_disabled() ) {
			return '';
		}

		$field_type  = $this->config['field_type'] ?? 'select';
		$options     = $this->build_options();
		$field_id    = $this->get_field_id();
		$field_value = $value ?? $this->config['default'] ?? '';
		$multiple    = ! empty( $this->config['multiple'] ) && 'select' === $field_type;

		$output  = $this->render_wrapper_start();
		$output .= $this->render_label();

		if ( 'radio' === $field_type ) {
			foreach ( $options as $opt_value => $opt_label ) {
				$checked  = ( (string) $opt_value === (string) $field_value ) ? ' checked' : '';
				$radio_id = $field_id . '_' . sanitize_key( (string) $opt_value );

				$output .= sprintf(
					'<label><input type="radio" id="%s" name="%s" value="%s"%s> %s</label><br>',
					esc_attr( $radio_id ),
					esc_attr( $this->name ),
					esc_attr( (string) $opt_value ),
					$checked,
					$opt_label
				);
			}
		} else {
			// Select.
			if ( $multiple && ! is_array( $field_value ) ) {
				$field_value = $field_value ? [ $field_value ] : [];
			}

			$attrs = sprintf(
				' id="%s" name="%s%s" class="regular-text"',
				esc_attr( $field_id ),
				esc_attr( $this->name ),
				$multiple ? '[]' : ''
			);

			if ( $multiple ) {
				$attrs .= ' multiple size="5"';
			}

			$placeholder = $this->config['placeholder'] ?? '';
			$output     .= '<select' . $attrs . '>';

			if ( $placeholder ) {
				$output .= sprintf( '<option value="">%s</option>', esc_html( $placeholder ) );
			}

			foreach ( $options as $opt_value => $opt_label ) {
				if ( '' === $opt_value && $placeholder ) {
					continue; // already output as placeholder
				}
				$selected = $multiple
					? in_array( (string) $opt_value, array_map( 'strval', (array) $field_value ), true )
					: ( (string) $opt_value === (string) $field_value );

				$output .= sprintf(
					'<option value="%s"%s>%s</option>',
					esc_attr( (string) $opt_value ),
					$selected ? ' selected' : '',
					$opt_label
				);
			}

			$output .= '</select>';
		}

		$output .= $this->render_description();
		$output .= $this->render_wrapper_end();

		return $output;
	}

	/**
	 * Sanitize the input value.
	 *
	 * @param mixed $input Raw input.
	 * @return int|int[]
	 */
	public function sanitize( $input ) {
		if ( is_array( $input ) ) {
			return array_map( 'absint', $input );
		}

		return $input !== '' ? absint( $input ) : '';
	}

	/**
	 * Save hook: optionally set taxonomy terms on the post.
	 *
	 * This is called manually in the CPT save handler when `save_terms` is true.
	 *
	 * @param int   $post_id The post ID being saved.
	 * @param mixed $value   The sanitized value.
	 * @return void
	 */
	public function maybe_save_terms( int $post_id, $value ): void {
		if ( empty( $this->config['save_terms'] ) ) {
			return;
		}

		$taxonomy = $this->config['taxonomy'] ?? '';

		if ( ! $taxonomy ) {
			return;
		}

		$term_ids = is_array( $value )
			? array_map( 'absint', $value )
			: ( $value !== '' ? [ absint( $value ) ] : [] );

		wp_set_post_terms( $post_id, $term_ids, $taxonomy );
	}
}
