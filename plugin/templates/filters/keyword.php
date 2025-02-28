<?php
/**
 * Displays a keyword search box filter.
 *
 * @package PedalCMS
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'label'       => pdl_get_label('keyword'),
    'placeholder' => pdl_get_label('keyword') . ' …'
];

$args = pdl_parse_template_args($args, $defaults, $template);

?>
<div class="nvis-filter-keyword nvis-filters-field">
    <label for="s" class="screen-reader-text"><?php echo esc_html($args['label']); ?></label>
    <input type="text" name="s" id="prog_keyword"
        placeholder="<?php echo esc_attr($args['placeholder']); ?>"
        value="<?php echo esc_attr(get_query_var('s')); ?>">
</div>