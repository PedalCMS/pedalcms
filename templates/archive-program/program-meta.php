<?php

pdl_get_template_part(
	'single-program/program-meta',
	[
		'post'            => $args['post'],
		'link_terms'      => false,
		'wrapper_class'   => 'item-meta',
		'meta_before_fmt' => '<div class="%s item-meta__item"><span class="label">%s<span class="separator">:</span></span> <span class="value">',
		'meta_after'      => '</span></div>',

	]
);
