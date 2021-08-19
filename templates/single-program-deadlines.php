  <?php if (have_rows('nvis_application_deadlines', 'option')) : ?>
    <div class="program-deadlines">
      <h2 class="program-deadlines__title program-sidebar__title">Application Deadlines</h2>
      <dl class="program-deadlines__list">
        <?php while (have_rows('nvis_application_deadlines', 'option')) : the_row(); ?>
          <dt><?php echo esc_html(get_sub_field('deadline_label')); ?></dt>
          <dd><?php echo esc_html(get_sub_field('deadline_info')); ?></dd>
        <?php endwhile; ?>
      </dl>
    </div>
  <?php endif;
