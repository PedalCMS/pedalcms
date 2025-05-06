<?php
/**
 * The template for displaying lead content on a Program Subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$subpage = pdl_get_active_subpage();

if ($subpage) :
  $field = str_replace('-', '_', $subpage) . '_lead';
  $class = sprintf('program-%s-lead-content', $subpage);
?>
<?php if (get_field($field)) : ?>
<div class="<?php echo $class; ?> program-lead-content">
  <?php the_field($field); ?>
</div>
<?php endif; ?>
<?php endif;
