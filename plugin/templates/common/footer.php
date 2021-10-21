<?php
/**
 * The template for displaying the document =footer.
 *
 * A thin wrapper around get_footer().
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

?>
</div><!-- .nvis-progs-template -->
<?php
do_action('nvis/programs/before_footer');
get_footer();
