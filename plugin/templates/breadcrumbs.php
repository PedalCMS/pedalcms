<?php

/**
 * Displays breadcrumbs for use in the page header.
 *
 * @package wp-career-profiles
 * @version 1.0
 */
?>
<div id="breadcrumbs" class="breadcrumbs careers-breadcrumbs">
  <?php
    /**
     * First, check for breadcrumb specific plugins. Then, look
     * for SEO plugins.
     */
    if (function_exists('bcn_display')) {
        bcn_display();
    } elseif (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb();
    } elseif (function_exists('aioseo_breadcrumbs')) {
        aioseo_breadcrumbs();
    }
  ?>
</div>
