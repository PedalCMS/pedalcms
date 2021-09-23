<section class="person-list">
	<?php if (is_array($data['people']) && !empty($data['people'])) : ?>

	<?php foreach ($data['people'] as $post) : ?>
	<article <?php post_class('', $post); ?>>
		<?php nvis_prog_get_template_part('single-person/featured-image', compact('post')); ?>
		<div class="person-info">
			<header>
				<h2 class="person-title"><a
						href="<?php echo get_the_permalink($post); ?>"><?php echo get_the_title($post); ?></a></h2>
				<?php the_terms($post, 'nvis_program_type'); ?>
			</header>

			<?php nvis_prog_get_template_part('blocks/job-title', compact('post')); ?>
			<?php nvis_prog_get_template_part('blocks/contact-info', compact('post')); ?>
		</div>
	</article>
	<?php endforeach; ?>

	<?php else: ?>

	<p class="empty-state-message">No one was found.</p>

	<?php endif; ?>
</section>