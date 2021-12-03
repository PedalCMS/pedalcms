<?php
/**
 * Displays a variety of Program meta items, for use in a list of Programs.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'show_college'          => true,
    'show_instruction_mode' => true,
    'show_prerequisites'    => true
];

$args = wp_parse_args($args, $defaults);

if ($post) : ?>
<div class="program-meta item-meta">

  <?php
  $terms_before = '<div class="%s item-meta__item"><span class="label">%s<span class="separator">:</span></span> <span class="value">';

  if ($args['show_college']) :
    // TODO: Link these to the college, not the archive.
    the_terms(
        $post,
        'nvis_program_college',
        sprintf($terms_before, 'program-college', 'College'),
        ', ',
        '</span></div>'
    );
  endif;

  if ($args['show_instruction_mode']) :
    // TODO: Link these somewhere else?
    the_terms(
        $post,
        'nvis_instruct_mode',
        sprintf($terms_before, 'instruction-mode', 'Instruction Mode'),
        ', ',
        '</span></div>'
    );
  endif;

  if ($args['show_prerequisites']) : ?>

  <div class="program-entrance-exam item-meta__item">
    <span class="label">Prerequisites<span class="separator">:</span></span>
    <span class="value"><?php echo get_field('prerequisites', $post) ? 'Yes' : 'No'; ?></span>
  </div>

  <?php endif; ?>

</div>
<?php endif;
