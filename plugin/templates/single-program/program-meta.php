<?php
/**
 * The template for displaying Program meta items, for use on single Program.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

?>
<div class="program-meta nvis-meta-group">

  <?php
  // TODO: Link these somewhere else?
  the_terms(
      get_the_ID(),
      'nvis_instruct_mode',
      '<span class="instruction-mode nvis-meta-group__item"><span class="label">Instruction Mode<span class="separator">:</span></span> <span class="value">',
      ', ',
      '</span></span>'
  ); ?>

  <span class="program-entrance-exam nvis-meta-group__item">
    <span class="label">Prerequisites<span class="separator">:</span></span>
    <span class="value"><?php echo get_field('prerequisites') ? 'Yes' : 'No'; ?></span>
  </span>

  <?php
  // TODO: Link these to the college, not the archive.
  the_terms(
      get_the_ID(),
      'nvis_program_college',
      '<span class="program-college nvis-meta-group__item"><span class="label">College<span class="separator">:</span></span> <span class="value"> ',
      ', ',
      '</span></span>'
  ); ?>

</div>