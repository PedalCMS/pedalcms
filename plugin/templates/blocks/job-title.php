<?php
/**
 * Displays the job title of a Person.
 *
 * Primarily used to render the JobTitle block but can be used anywhere.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

if (isset($data['job_title'])) :?>
<div class="person-job-title">
    <?php echo esc_html($data['job_title']); ?>
</div>
<?php endif;
