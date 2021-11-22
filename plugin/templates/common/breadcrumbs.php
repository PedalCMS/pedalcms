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

$defaults = [
    'show_breadcrumbs'         => true,
    'breadcrumb_wrapper_id'    => 'breadcrumbs',
    'breadcrumb_wrapper_class' => 'breadcrumbs'
];

$args = wp_parse_args($args, $defaults);

if ($args['show_breadcrumbs']) :
/**
 * Fires before the breadcrumbs are loaded.
 *
 * @since 0.1
 *
 */
do_action('nvis/programs/before_breadcrumbs');

?>
<div id="<?php echo esc_attr($args['breadcrumb_wrapper_id']); ?>"
    class="nvis-breadcrumbs <?php echo esc_attr($args['breadcrumb_wrapper_class']); ?>">
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

endif;
