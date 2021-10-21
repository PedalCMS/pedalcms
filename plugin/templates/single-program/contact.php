<?php
defined('ABSPATH') || exit;

$contacts = get_field('related_contacts');

if (is_array($contacts) && !empty($contacts)) :
?>
<div class="program-contacts">
  <h2 class="program-contacts__title program-sidebar__title">
    <?php echo esc_html(get_option('options_nvis_program_contact_label', 'Program Contact')); ?>
  </h2>
  <?php
  foreach ($contacts as $post) :
    nvis_prog_get_template_part('single-program/contact-item', compact('post'));
  endforeach;
  ?>
</div>
<?php endif; ?>

<?php
$action = 'contact';
$url = nvis_prog_get_action_link($action);

if ($url) :
?>
<a class="<?php echo $action; ?>-button button button-secondary"
  href="<?php echo esc_url($url); ?>">Contact</a>
<?php endif;
