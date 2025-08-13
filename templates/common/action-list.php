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
		foreach ( $args['actions'] as $i => $action ) :
			if ( empty( $action['url'] ) || empty( $action['label'] ) ) {
				continue;
			}

			$class  = $action['key'] ? str_replace( '_', '-', $action['key'] ) : '';
			$class .= ' button ';
			$class .= $i ? 'button-secondary' : 'button-primary';

			printf(
				'<li><a class="%s" href="%s">%s</a></li>',
				esc_attr( $class ),
				esc_url( $action['url'] ),
				esc_html( $action['label'] )
			);
		endforeach;
		?>
	</ul>
</div>
	<?php
endif;
