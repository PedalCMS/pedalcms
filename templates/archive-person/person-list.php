<?php
/**
 * Displays a list of Person items, for use in an archive.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_defaults = [
	'people'                   => null,
	'layout'                   => 'grid',
	'show_contact_info'        => true,
	'show_contact_info_labels' => false,
	'img_size'                 => 'medium',
	'label_no_one_found'       => pedalcms_get_post_type_label( 'pedalcms_person', 'not_found' ),
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

$pedalcms_classes = [
	'person-list',
	'person-list--' . $pedalcms_args['layout'],
];
?>
<section
	class="<?php echo esc_attr( implode( ' ', $pedalcms_classes ) ); ?>">
	<?php
	if ( is_array( $pedalcms_args['people'] ) && ! empty( $pedalcms_args['people'] ) ) :
		foreach ( $pedalcms_args['people'] as $pedalcms_person_post ) :
			$pedalcms_args['person_post'] = $pedalcms_person_post;
			pedalcms_get_template_part( 'archive-person/person-item', $pedalcms_args );
		endforeach;
	else :
		?>

	<p class="empty-state-message"><?php echo esc_html( $pedalcms_args['label_no_one_found'] ); ?>
	</p>

	<?php endif; ?>
</section>
