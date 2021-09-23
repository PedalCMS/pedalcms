<section class="programs-list">
	<?php if (is_array($data['programs']) && !empty($data['programs'])) :
        foreach ($data['programs'] as $post) :
            nvis_prog_get_template_part('archive-program/program-item', compact('post'));
        endforeach;
    else: ?>

	<p class="empty-state-message">No programs were found.</p>

	<?php endif; ?>
</section>