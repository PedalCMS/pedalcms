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
    'deadlines' => pdl_the_application_deadlines(),
    'heading'   => pdl_get_label('application_deadlines')
];

$args = pdl_parse_template_args($args, $defaults, $template);

if (is_array($args['deadlines'])) : ?>
<div class="program-deadlines">
  <h2 class="program-deadlines__title program-sidebar__title"><?php echo esc_html($args['heading']); ?>
  </h2>
  <dl class="program-deadlines__list">
    <?php foreach ($args['deadlines'] as $deadline) : ?>
    <dt><?php echo esc_html($deadline['label']); ?>
    </dt>
    <dd><?php echo esc_html($deadline['info']); ?>
    </dd>
    <?php endforeach; ?>
  </dl>
</div>
<?php endif;
