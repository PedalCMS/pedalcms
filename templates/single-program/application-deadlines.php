<?php
/**
 * The template for displaying the Program's application deadlines.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'deadlines' => pedalcms_the_application_deadlines(),
	'heading'   => pedalcms_get_label( 'application_deadlines' ),
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

if ( is_array( $pedalcms_args['deadlines'] ) && ! empty( $pedalcms_args['deadlines'] ) ) : ?>
<div class="program-deadlines">
	<h2 class="program-deadlines__title program-sidebar__title"><?php echo esc_html( $pedalcms_args['heading'] ); ?>
	</h2>
	<dl class="program-deadlines__list">
	<?php foreach ( $pedalcms_args['deadlines'] as $pedalcms_deadline ) : ?>
	<dt><?php echo esc_html( $pedalcms_deadline['label'] ); ?>
	</dt>
	<dd><?php echo esc_html( $pedalcms_deadline['info'] ); ?>
	</dd>
	<?php endforeach; ?>
	</dl>
</div>
	<?php
endif;
