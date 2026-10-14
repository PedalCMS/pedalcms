<?php
/**
 * Displays a keyword search box filter.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'label'       => pedalcms_get_label( 'keyword' ),
	'placeholder' => pedalcms_get_label( 'keyword' ) . ' …',
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

?>
<div class="pdl-filter-keyword pdl-filters-field">
	<label for="s" class="pdl-filters-field__label"><?php echo esc_html( $pedalcms_args['label'] ); ?></label>
	<input type="text" name="s" id="prog_keyword"
		placeholder="<?php echo esc_attr( $pedalcms_args['placeholder'] ); ?>"
		value="<?php echo esc_attr( get_query_var( 's' ) ); ?>">
</div>
