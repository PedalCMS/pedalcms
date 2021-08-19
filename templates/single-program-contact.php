<?php
$contacts = get_field('related_contacts');
if (is_array($contacts) && !empty($contacts)) :
?>
  <div class="program-contacts">
    <h2 class="program-contacts__title program-sidebar__title">Program Contact</h2>
    <?php foreach ($contacts as $contact) : get_post_meta($contact); ?>
      <div class="program-contact">
        <?php echo get_the_post_thumbnail($contact, 'thumbnail', ['class' => 'program-contact__picture']); ?>
        <div class="program-contact__name"><?php echo get_the_title($contact); ?></div>

        <?php if (get_field('job_title', $contact)) : ?>
          <div class="program-contact__title"><?php the_field('job_title', $contact); ?></div>
        <?php endif; ?>

        <?php if (get_field('office_phone', $contact)) : ?>
          <div class="program-contact__phone">
            <?php the_field('office_phone', $contact); ?>
          </div>
        <?php endif; ?>

        <?php if (get_field('email_address', $contact)) : ?>
          <div class="program-contact__email">
            <a href="mailto:<?php echo antispambot(get_field('email_address', $contact), true); ?>"><?php echo antispambot(get_field('email_address', $contact)); ?></a>
          </div>
        <?php endif; ?>

      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php
$action = 'contact';
$url = nvis_prog_get_action_link($action);
if ($url) :
?>
  <a class="<?php echo $action; ?>-button button button-secondary" href="<?php echo esc_url($url); ?>">Contact</a>
<?php endif; ?>
