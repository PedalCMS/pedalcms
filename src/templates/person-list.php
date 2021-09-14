<section class="person-list">
	<?php if (is_array($data['people']) && !empty($data['people'])) : ?>

	<?php foreach ($data['people'] as $person) : ?>
	<article <?php post_class('', $person); ?>>

		<?php if (has_post_thumbnail($person)):?>
		<div class="person-featured-image">
			<?php echo get_the_post_thumbnail($person, 'medium'); ?>
		</div>
		<?php endif; ?>

		<div class="person-info">
			<header>
				<h2 class="person-title"><a
						href="<?php echo get_the_permalink($person); ?>"><?php echo get_the_title($person); ?></a></h2>
				<?php the_terms($person, 'nvis_program_type'); ?>
			</header>

			<?php if (get_field('job_title', $person)) : ?>
			<div class="program-contact__title"><?php the_field('job_title', $person); ?>
			</div>
			<?php endif; ?>

			<?php if (get_field('office_phone', $person)) : ?>
			<div class="program-contact__phone">
				<?php the_field('office_phone', $person); ?>
			</div>
			<?php endif; ?>

			<?php if (get_field('email_address', $person)) : ?>
			<div class="program-contact__email">
				<a
					href="mailto:<?php echo antispambot(get_field('email_address', $person), true); ?>"><?php echo antispambot(get_field('email_address', $person)); ?></a>
			</div>
			<?php endif; ?>

		</div>
	</article>
	<?php endforeach; ?>

	<?php else: ?>

	<p class="empty-state-message">No one was found.</p>

	<?php endif; ?>
</section>