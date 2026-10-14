<?php
/**
 * Displays a list of Program items, for use in an archive.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'label_no_programs_found' => pedalcms_get_label( 'no_programs_found' ),
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

?>
<section class="programs-list">
	<?php
	if ( is_array( $pedalcms_args['programs'] ) && ! empty( $pedalcms_args['programs'] ) ) :
		foreach ( $pedalcms_args['programs'] as $pedalcms_program_post ) :
			pedalcms_get_template_part( 'archive-program/program-item', [ 'program_post' => $pedalcms_program_post ] );
		endforeach;
	else :
		?>

	<p class="empty-state-message"><?php echo esc_html( $pedalcms_args['label_no_programs_found'] ); ?>
	</p>

	<?php endif; ?>
</section>
