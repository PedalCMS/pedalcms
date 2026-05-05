<?php
/**
 * The template for displaying the Faculty & Staff Program Subpage.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$program_post = pdl_args_or_global( 'post', $args );

$defaults = [
	'show_subpage'             => pdl_show_subpage( 'faculty-staff' ),
	'show_contact_info_labels' => true,
	'personnel'                => post_type_exists( 'pdl_person' ) ? get_field( 'related_faculty_staff', $program_post ) : [],
	'group_by_category'        => get_field( 'faculty_staff_by_category', $program_post ),
	'image_size'               => 'thumbnail',
];

$args = pdl_parse_template_args( $args, $defaults, $template );

if ( $args['show_subpage'] ) : ?>
<div <?php pdl_subpage_class(); ?>>
	<h2 class="program-subpage__title"><?php echo esc_html( pdl_subpage_title() ); ?></h2>

	<div class="program-subpage__content">

	<?php pdl_get_template_part( 'single-program/subpages/lead-content' ); ?>

	<div class="program-faculty-staff-list">
		<?php
		if ( ! empty( $args['personnel'] ) ) :
			$h_level = 3;

			if ( $args['group_by_category'] ) :
				$cats    = pdl_get_people_by_category( $args['personnel'] );
				$h_level = 4;

				foreach ( $cats as $person_cat ) :
					?>
		<div class="person-category">
		<h3 id="<?php echo esc_attr( $person_cat->slug ); ?>"
			class="person-category__title">
					<?php echo esc_html( $person_cat->name ); ?>
		</h3>
		<div class="person-category__list person-list">
					<?php
					foreach ( $person_cat->people as $person ) :
						$person = get_post( $person );
						pdl_get_template_part(
							'archive-person/person-item',
							[
								'person_post'              => $person,
								'h_level'                  => $h_level,
								'img_size'                 => $args['image_size'],
								'show_contact_info_labels' => $args['show_contact_info_labels'],
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
				foreach ( $args['personnel'] as $person ) :
					pdl_get_template_part(
						'archive-person/person-item',
						[
							'person_post'              => $person,
							'h_level'                  => $h_level,
							'img_size'                 => $args['image_size'],
							'show_contact_info_labels' => $args['show_contact_info_labels'],
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
