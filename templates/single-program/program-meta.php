<?php
/**
 * The template for displaying Program meta items, for use on single Program.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

$pedalcms_program_post = pedalcms_args_or_global( 'post', $args );

$pedalcms_defaults = [
	'show_college'           => true,
	'show_department'        => true,
	'show_instruction_mode'  => true,
	'show_prerequisites'     => true,
	'link_terms'             => true,
	'label_instruction_mode' => pedalcms_get_taxonomy_label( 'pedalcms_instruct_mode', 'singular_name' ),
	'label_prerequisites'    => pedalcms_get_label( 'prerequisites' ),
	'label_department'       => pedalcms_get_taxonomy_label( 'pedalcms_department', 'singular_name' ),
	'label_college'          => pedalcms_get_taxonomy_label( 'pedalcms_college', 'singular_name' ),
	'label_yes'              => pedalcms_get_label( 'yes' ),
	'label_no'               => pedalcms_get_label( 'no' ),
	'wrapper_class'          => 'pdl-meta-group',
	'meta_before_fmt'        => '<span class="%s pdl-meta-group__item"><span class="label">%s<span class="separator">:</span></span> <span class="value">',
	'terms_separator'        => ', ',
	'meta_after'             => '</span></span>',
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

$pedalcms_classes = [
	'program-meta',
	esc_attr( $pedalcms_args['wrapper_class'] ),
];

printf( '<div class="%s">', esc_attr( implode( ' ', $pedalcms_classes ) ) );

if ( $pedalcms_args['show_instruction_mode'] && taxonomy_exists( 'pedalcms_instruct_mode' ) ) :
	echo wp_kses_post(
		pedalcms_get_the_term_list(
			$pedalcms_program_post->ID,
			'pedalcms_instruct_mode',
			sprintf( wp_kses_post( $pedalcms_args['meta_before_fmt'] ), 'instruction-mode', $pedalcms_args['label_instruction_mode'] ),
			$pedalcms_args['terms_separator'],
			wp_kses_post( $pedalcms_args['meta_after'] ),
			$pedalcms_args['link_terms']
		)
	);
endif;

if ( $pedalcms_args['show_prerequisites'] ) :
	printf( wp_kses_post( $pedalcms_args['meta_before_fmt'] ), 'prerequisites', esc_html( $pedalcms_args['label_prerequisites'] ) );
	echo esc_html( pedalcms_get_field( 'pedalcms_prerequisites', $pedalcms_program_post ) ? $pedalcms_args['label_yes'] : $pedalcms_args['label_no'] );
	echo wp_kses_post( $pedalcms_args['meta_after'] );
endif;

if ( $pedalcms_args['show_college'] && taxonomy_exists( 'pedalcms_college' ) ) :
	echo wp_kses_post(
		pedalcms_get_the_term_list(
			$pedalcms_program_post->ID,
			'pedalcms_college',
			sprintf( $pedalcms_args['meta_before_fmt'], 'program-college', $pedalcms_args['label_college'] ),
			$pedalcms_args['terms_separator'],
			$pedalcms_args['meta_after'],
			$pedalcms_args['link_terms']
		)
	);
endif;

if ( $pedalcms_args['show_department'] && taxonomy_exists( 'pedalcms_department' ) ) :
	echo wp_kses_post(
		pedalcms_get_the_term_list(
			$pedalcms_program_post->ID,
			'pedalcms_department',
			sprintf( $pedalcms_args['meta_before_fmt'], 'department', $pedalcms_args['label_department'] ),
			$pedalcms_args['terms_separator'],
			$pedalcms_args['meta_after'],
			$pedalcms_args['link_terms']
		)
	);
endif;

echo '</div>';
