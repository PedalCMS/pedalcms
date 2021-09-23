<?php
// Prime the cache. We will be getting a lot of meta.
get_post_meta(get_the_ID());

nvis_prog_get_template_part('header');
?>
<article <?php post_class(); ?>>
	<?php nvis_prog_get_template_part('single-person/page-header-classic'); ?>
	<div class="program-main entry-content">
		<?php the_content(); ?>
	</div>
</article>
<?php nvis_prog_get_template_part('footer');
