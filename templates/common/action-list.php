<?php

defined( 'ABSPATH' ) || exit;

$pedalcms_classes = [
	'action-list',
];

$pedalcms_classes[] = $args['wrapper_class'] ?? '';

if ( ! empty( $args['actions'] ) ) : ?>
<div
	class="<?php echo esc_attr( implode( ' ', $pedalcms_classes ) ); ?>">
	<ul>
		<?php
		foreach ( $args['actions'] as $pedalcms_i => $pedalcms_action_item ) :
			if ( empty( $pedalcms_action_item['url'] ) || empty( $pedalcms_action_item['label'] ) ) {
				continue;
			}

			$pedalcms_class  = $pedalcms_action_item['key'] ? str_replace( '_', '-', $pedalcms_action_item['key'] ) : '';
			$pedalcms_class .= ' button ';
			$pedalcms_class .= $pedalcms_i ? 'button-secondary' : 'button-primary';

			printf(
				'<li><a class="%s" href="%s">%s</a></li>',
				esc_attr( $pedalcms_class ),
				esc_url( $pedalcms_action_item['url'] ),
				esc_html( $pedalcms_action_item['label'] )
			);
		endforeach;
		?>
	</ul>
</div>
	<?php
endif;
