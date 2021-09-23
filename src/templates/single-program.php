<?php
// Prime the cache. We will be getting a lot of meta.
get_post_meta(get_the_ID());

nvis_prog_get_template_part('header');
?>
<article <?php post_class(); ?>>
	<?php nvis_prog_get_template_part('single-program/page-header'); ?>
	<div class="program-main entry-content">
		<?php nvis_prog_get_template_part('single-program/subpages/' . nvis_prog_get_active_subpage()); ?>
	</div>
	<?php nvis_prog_get_template_part('single-program/sidebar'); ?>
</article>
<?php nvis_prog_get_template_part('footer');
