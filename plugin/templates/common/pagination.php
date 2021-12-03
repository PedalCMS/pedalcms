<?php
/**
 * Displays pagination navigation, for use in archives.
 *
 * Prefers third party plugins to handle rendering links but falls back to
 * native WordPress paginate_links(). Supports:
 * - WP-PageNavi
 * - WP-Paginate
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

/**
 * Fires before the pagination is loaded.
 *
 * @since 0.1
 *
 * @param array $args The arguments passed to the template.
 *
 */
do_action('nvis/programs/before_pagination', $args);

?>
<nav class="pagination">
  <?php
    if (function_exists('wp_pagenavi')) {
        wp_pagenavi();
    } elseif (function_exists('wp_paginate')) {
        wp_paginate();
    } else {
        global $wp_query;
        echo paginate_links([
            'total'        => $wp_query->max_num_pages,
            'show_all'     => false,
            'type'         => 'plain',
            'end_size'     => 1,
            'mid_size'     => 1,
            'prev_next'    => true,
        ]);
    }
  ?>
</nav>
<?php
/**
 * Fires after the pagination is loaded.
 *
 * @since 0.1
 *
 * @param array $args The arguments passed to the template.
 *
 */
do_action('nvis/programs/after_pagination', $args);
