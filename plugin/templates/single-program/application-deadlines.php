<?php
/**
 * The template for displaying the Program's application deadlines.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'deadlines' => nvis_prog_the_application_deadlines(),
    'heading'   => nvis_prog_get_label('application_deadlines')
];

$args = wp_parse_args($args, $defaults);

if (is_array($args['deadlines'])) : ?>
<div class="program-deadlines">
  <h2 class="program-deadlines__title program-sidebar__title"><?php echo esc_html($args['heading']); ?>
  </h2>
  <dl class="program-deadlines__list">
    <?php foreach ($args['deadlines'] as $deadline) : ?>
    <dt><?php echo esc_html($deadline['deadline_label']); ?>
    </dt>
    <dd><?php echo esc_html($deadline['deadline_info']); ?>
    </dd>
    <?php endforeach; ?>
  </dl>
</div>
<?php endif;
