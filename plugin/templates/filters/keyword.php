<?php
/**
 * Displays a keyword search box filter.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

?>
<div class="nvis-filter-keyword nvis-filters-field">
    <label for="s" class="screen-reader-text">Keyword</label>
    <input type="text" name="s" id="prog_keyword" placeholder="Keyword …"
        value="<?php echo esc_attr(get_query_var('s')); ?>">
</div>