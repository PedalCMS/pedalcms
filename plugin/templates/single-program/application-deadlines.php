<?php
/**
 * The template for displaying the Program's application deadlines.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$deadlines = nvis_prog_the_application_deadlines();

if (is_array($deadlines)) : ?>
<div class="program-deadlines">
  <h2 class="program-deadlines__title program-sidebar__title">Application Deadlines</h2>
  <dl class="program-deadlines__list">
    <?php foreach ($deadlines as $deadline) : ?>
    <dt><?php echo esc_html($deadline['deadline_label']); ?>
    </dt>
    <dd><?php echo esc_html($deadline['deadline_info']); ?>
    </dd>
    <?php endforeach; ?>
  </dl>
</div>
<?php endif;
