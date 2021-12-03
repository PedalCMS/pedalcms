<?php
/**
 * Displays a keyword search box filter.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'label'       => 'Keyword',
    'placeholder' => 'Keyword …'
];

$args = wp_parse_args($args, $defaults);

?>
<div class="nvis-filter-keyword nvis-filters-field">
    <label for="s" class="screen-reader-text"><?php echo esc_html($args['label']); ?></label>
    <input type="text" name="s" id="prog_keyword"
        placeholder="<?php echo esc_attr($args['placeholder']); ?>"
        value="<?php echo esc_attr(get_query_var('s')); ?>">
</div>