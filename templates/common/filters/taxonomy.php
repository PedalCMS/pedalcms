<?php
/**
 * Displays a dropdown filter for a given taxonomy.
 *
 * An abstract template. Only meant to be referenced by other filter templates.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */


defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'taxonomy'             => null,
	'query_var'            => null,
	'label'                => null,
	'label_none_selected'  => null,
	'none_selected_prefix' => pedalcms_get_label( 'none_selected_prefix' ),
	'missing_data_text'    => pedalcms_get_label( 'missing_filter_data' ),
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

if ( ! taxonomy_exists( $pedalcms_args['taxonomy'] ) ) {
	return;
}

$pedalcms_label         = $pedalcms_args['label'] ?? pedalcms_get_taxonomy_label( $pedalcms_args['taxonomy'], 'singular_name' );
$pedalcms_short_label   = $pedalcms_args['short_label'] ?? $pedalcms_label;
$pedalcms_none_selected = $pedalcms_args['label_none_selected'] ??
	pedalcms_get_taxonomy_label( $pedalcms_args['taxonomy'], 'none_selected' ) ??
	$pedalcms_args['none_selected_prefix'] . $pedalcms_short_label;

if ( $pedalcms_args['taxonomy'] && $pedalcms_args['query_var'] && $pedalcms_label ) : ?>
<div
	class="pdl-filter-<?php echo esc_attr( $pedalcms_args['query_var'] ); ?> pdl-filters-field">
	<label
		for="<?php echo esc_attr( $pedalcms_args['query_var'] ); ?>"
		class="pdl-filters-field__label"><?php echo esc_html( $pedalcms_label ); ?></label>
	<?php
	wp_dropdown_categories(
		[
			'taxonomy'          => $pedalcms_args['taxonomy'],
			'name'              => $pedalcms_args['query_var'],
			'selected'          => get_query_var( $pedalcms_args['query_var'] ),
			'show_option_none'  => $pedalcms_none_selected,
			'option_none_value' => '',
			'value_field'       => 'slug',
		]
	);
	?>
</div>
<?php else : ?>
<div>
	<?php printf( esc_html( $pedalcms_args['missing_data_text'] ), esc_html( $pedalcms_args['taxonomy'] ) ); ?>
</div>
	<?php
endif;
