<section class="programs-list">
	<?php if (is_array($data['programs']) && !empty($data['programs'])) : ?>

	<?php foreach ($data['programs'] as $program) : ?>
		<article <?php post_class('', $program); ?>>
			
			<?php if (has_post_thumbnail($program)):?>
			<div class="program-featured-image">
				<?php echo get_the_post_thumbnail($program, 'medium'); ?>
			</div>
			<?php endif; ?>

			<div class="program-info">
				<header>
					<h2 class="program-title"><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></h2>
					<?php the_terms($program, 'nvis_program_type'); ?>
				</header>
				<?php nvis_prog_get_template_part('archive-program-meta', compact('program')); ?>
			</div>
			<?php
                $add_permalink = get_permalink($program);
                nvis_prog_get_template_part('program-actions', compact('add_permalink'));
            ?>
		</article>
	<?php endforeach; ?>

	<?php else: ?>
	
	<p class="empty-state-message">No programs were found.</p>
	
	<?php endif; ?>
</section>
