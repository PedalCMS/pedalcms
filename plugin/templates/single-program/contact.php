<?php
/**
 * The template for displaying the Program contact section.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'action'                => 'contact',
    'label_program_contact' => pdl_get_label('program_contact'),
    'label_contact_action'  => pdl_get_label('contact_action'),
    'contacts'              => post_type_exists('pdl_person') ? get_field('related_contacts') : [],
];

$args = pdl_parse_template_args($args, $defaults, $template);
$action_url = pdl_get_action_link($args['action']);

if (is_array($args['contacts']) && !empty($args['contacts'])) :
?>
<div class="program-contacts">
  <h2 class="program-contacts__title program-sidebar__title">
    <?php echo esc_html($args['label_program_contact']); ?>
  </h2>
  <?php
  foreach ($args['contacts'] as $post) :
    pdl_get_template_part('single-program/contact-item', compact('post'));
  endforeach;
  ?>
</div>
<?php endif; ?>

<?php if ($action_url) : ?>
<a class="<?php echo $args['action']; ?>-button button button-secondary"
  href="<?php echo esc_url($action_url); ?>"><?php echo $args['label_contact_action']; ?></a>
<?php endif;
