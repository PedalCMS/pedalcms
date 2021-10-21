<?php
/**
 * Displays a breadcrumb trail, for use in the page header.
 *
 * Relies on third party plugins to handle rendering breadcrumbs. Supports:
 * - Breadcrumb NavXT
 * - Yoast SEO
 * - All in One SEO
 * - Rank Math
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;


/**
 * Fires before the breadcrumbs are loaded.
 *
 * @since 0.1
 *
 */
do_action('nvis/programs/before_breadcrumbs');

?>
<div id="breadcrumbs" class="breadcrumbs careers-breadcrumbs">
  <?php
    if (function_exists('bcn_display')) {
        bcn_display();
    } elseif (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb();
    } elseif (function_exists('aioseo_breadcrumbs')) {
        aioseo_breadcrumbs();
    } elseif (function_exists('rank_math_the_breadcrumbs')) {
        rank_math_the_breadcrumbs();
    }
  ?>
</div>
<?php
/**
 * Fires after the breadcrumbs are loaded.
 *
 * @since 0.1
 *
 */
do_action('nvis/programs/after_breadcrumbs');
