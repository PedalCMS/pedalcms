<?php
/**
 * The template for displaying the Program contact section.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$defaults = [
    'action'        => 'contact',
    'label_contact' => 'Contact',
    'contacts'      => get_field('related_contacts'),
];

$args = wp_parse_args($args, $defaults);
$action_url = nvis_prog_get_action_link($args['action']);

if (is_array($args['contacts']) && !empty($args['contacts'])) :
?>
<div class="program-contacts">
  <h2 class="program-contacts__title program-sidebar__title">
    <?php echo esc_html(get_option('options_nvis_program_contact_label', 'Program Contact')); ?>
  </h2>
  <?php
  foreach ($args['contacts'] as $post) :
    nvis_prog_get_template_part('single-program/contact-item', compact('post'));
  endforeach;
  ?>
</div>
<?php endif; ?>

<?php if ($action_url) : ?>
<a class="<?php echo $args['action']; ?>-button button button-secondary"
  href="<?php echo esc_url($action_url); ?>"><?php echo $args['label_contact']; ?></a>
<?php endif;
