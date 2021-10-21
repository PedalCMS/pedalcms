<?php
/**
 * Displays a variety of Program meta items, for use in a list of Programs.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = $data['post'] ?? null;

if ($post) : ?>
<div class="program-meta">
  <?php
    // TODO: Link these to the college, not the archive.
    the_terms(
        $post,
        'nvis_program_college',
        '<div class="program-college program-meta__item">College: ',
        ', ',
        '</div>'
    ); ?>

  <?php
    // TODO: Link these somewhere else?
    the_terms(
        $post,
        'nvis_program_format',
        '<div class="program-format program-meta__item">Delivery Format: ',
        ', ',
        '</div>'
    ); ?>

  <div class="program-entrance-exam program-meta__item">
    Prerequisites:
    <?php echo get_field('prerequisites') ? 'Yes' : 'No'; ?>
  </div>

</div>
<?php endif;
