<?php

$classes = [
	'action-list',
];

$classes[] = $args['wrapper_class'] ?? '';

if ( ! empty( $args['actions'] ) ) : ?>
<div
	class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<ul>
		<?php
		foreach ( $args['actions'] as $i => $action_item ) :
			if ( empty( $action_item['url'] ) || empty( $action_item['label'] ) ) {
				continue;
			}

			$class  = $action_item['key'] ? str_replace( '_', '-', $action_item['key'] ) : '';
			$class .= ' button ';
			$class .= $i ? 'button-secondary' : 'button-primary';

			printf(
				'<li><a class="%s" href="%s">%s</a></li>',
				esc_attr( $class ),
				esc_url( $action_item['url'] ),
				esc_html( $action_item['label'] )
			);
		endforeach;
		?>
	</ul>
</div>
	<?php
endif;
