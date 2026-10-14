<?php
/**
 * The template for displaying the Faculty & Staff Program Subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_program_post = pedalcms_args_or_global( 'post', $args );

$pedalcms_defaults = [
	'show_subpage'             => pedalcms_show_subpage( 'faculty-staff' ),
	'show_contact_info_labels' => true,
	'personnel'                => post_type_exists( 'pedalcms_person' ) ? pedalcms_get_field( 'pedalcms_related_faculty_staff', $pedalcms_program_post ) : [],
	'group_by_category'        => pedalcms_get_field( 'pedalcms_faculty_staff_by_category', $pedalcms_program_post ),
	'image_size'               => 'thumbnail',
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

if ( $pedalcms_args['show_subpage'] ) : ?>
<div <?php pedalcms_subpage_class(); ?>>
	<h2 class="program-subpage__title"><?php echo esc_html( pedalcms_subpage_title() ); ?></h2>

	<div class="program-subpage__content">

	<?php pedalcms_get_template_part( 'single-program/subpages/lead-content' ); ?>

	<div class="program-faculty-staff-list">
		<?php
		if ( ! empty( $pedalcms_args['personnel'] ) ) :
			$pedalcms_h_level = 3;

			if ( $pedalcms_args['group_by_category'] ) :
				$pedalcms_cats    = pedalcms_get_people_by_category( $pedalcms_args['personnel'] );
				$pedalcms_h_level = 4;

				foreach ( $pedalcms_cats as $pedalcms_person_cat ) :
					?>
		<div class="person-category">
		<h3 id="<?php echo esc_attr( $pedalcms_person_cat->slug ); ?>"
			class="person-category__title">
					<?php echo esc_html( $pedalcms_person_cat->name ); ?>
		</h3>
		<div class="person-category__list person-list">
					<?php
					foreach ( $pedalcms_person_cat->people as $pedalcms_person ) :
						$pedalcms_person = get_post( $pedalcms_person );
						pedalcms_get_template_part(
							'archive-person/person-item',
							[
								'person_post'              => $pedalcms_person,
								'h_level'                  => $pedalcms_h_level,
								'img_size'                 => $pedalcms_args['image_size'],
								'show_contact_info_labels' => $pedalcms_args['show_contact_info_labels'],
								'context'                  => $template,
							]
						);
					endforeach;
					?>
		</div>
		</div>
					<?php
				endforeach;
			else :
				?>
		<div class="person-list">
				<?php
				foreach ( $pedalcms_args['personnel'] as $pedalcms_person ) :
					pedalcms_get_template_part(
						'archive-person/person-item',
						[
							'person_post'              => $pedalcms_person,
							'h_level'                  => $pedalcms_h_level,
							'img_size'                 => $pedalcms_args['image_size'],
							'show_contact_info_labels' => $pedalcms_args['show_contact_info_labels'],
						]
					);
			endforeach;
				?>
		</div>
				<?php
			endif;
		endif;
		?>
	</div>

	</div>
</div>
	<?php
endif;
