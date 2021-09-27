<?php nvis_prog_get_template_part('header'); ?>
<article <?php post_class(); ?>>
	<?php nvis_prog_get_template_part('single-course/page-header'); ?>
	<div class="program-main entry-content">
		<?php the_content(); ?>
	</div>
</article>
<?php nvis_prog_get_template_part('footer');
