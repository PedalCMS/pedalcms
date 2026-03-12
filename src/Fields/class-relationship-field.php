<?php
/**
 * Relationship_Field - CassetteCMF custom field type.
 *
 * Renders a multi-select or searchable list of posts from one or more
 * post types, storing post IDs as an array.
 *
 * @package PedalCMS\Fields
 * @since 0.3.0
 */

namespace PedalCMS\Fields;

use Pedalcms\CassetteCmf\Field\Abstract_Field;

/**
 * Relationship_Field class
 *
 * Configuration options:
 * - post_type:  (string|string[]) Post type(s) to pull from. Default 'post'.
 * - multiple:   (bool) Allow multiple selections. Default true.
 * - return_format: 'id' (default) — currently only IDs are stored.
 */
class Relationship_Field extends Abstract_Field {

	/**
	 * Get field type defaults.
	 *
	 * @return array<string, mixed>
	 */
	protected function get_defaults(): array {
		return array_merge(
			parent::get_defaults(),
			[
				'post_type'     => 'post',
				'multiple'      => true,
				'return_format' => 'id',
				'posts_per_page' => 50,
			]
		);
	}

	/**
	 * Fetch posts for the configured post type(s).
	 *
	 * @return \WP_Post[]
	 */
	protected function get_posts(): array {
		$post_type = $this->config['post_type'] ?? 'post';

		$query = new \WP_Query( [
			'post_type'      => $post_type,
			'posts_per_page' => (int) ( $this->config['posts_per_page'] ?? 50 ),
			'post_status'    => 'publish',
			'orderby'        => 'title',
			'order'          => 'ASC',
			'fields'         => 'all',
		] );

		return $query->posts;
	}

	/**
	 * Render the relationship field.
	 *
	 * Outputs a multi-select. In a future iteration this could
	 * be upgraded to a drag-and-drop list.
	 *
	 * @param mixed $value Current value (array of post IDs).
	 * @return string HTML output.
	 */
	public function render( $value = null ): string {
		$posts    = $this->get_posts();
		$field_id = $this->get_field_id();
		$multiple = ! empty( $this->config['multiple'] );
		$selected = (array) ( $value ?? $this->config['default'] ?? [] );

		$output  = $this->render_wrapper_start();
		$output .= $this->render_label();

		$attrs = sprintf(
			' id="%s" name="%s%s" class="regular-text" size="8"',
			esc_attr( $field_id ),
			esc_attr( $this->name ),
			$multiple ? '[]' : ''
		);

		if ( $multiple ) {
			$attrs .= ' multiple';
		}

		$output .= '<select' . $attrs . '>';

		foreach ( $posts as $post ) {
			$is_selected = in_array( (string) $post->ID, array_map( 'strval', $selected ), true );
			$output     .= sprintf(
				'<option value="%d"%s>%s</option>',
				$post->ID,
				$is_selected ? ' selected' : '',
				esc_html( $post->post_title )
			);
		}

		$output .= '</select>';

		if ( $multiple ) {
			$output .= sprintf(
				'<p class="description">%s</p>',
				esc_html__( 'Hold Ctrl / Cmd to select multiple.', 'pedalcms' )
			);
		}

		$output .= $this->render_description();
		$output .= $this->render_wrapper_end();

		return $output;
	}

	/**
	 * Sanitize the input value.
	 *
	 * @param mixed $input Raw input.
	 * @return int[]
	 */
	public function sanitize( $input ): array {
		if ( ! is_array( $input ) ) {
			$input = $input ? [ $input ] : [];
		}

		return array_values( array_map( 'absint', array_filter( $input ) ) );
	}
}
