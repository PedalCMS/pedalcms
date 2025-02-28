<?php
/**
 * The template for displaying Program meta items, for use on single Program.
 *
 * @package PedalCMS
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = pdl_args_or_global('post', $args);

$defaults = [
    'show_college'           => true,
    'show_department'        => true,
    'show_instruction_mode'  => true,
    'show_prerequisites'     => true,
    'link_terms'             => true,
    'label_instruction_mode' => pdl_get_taxonomy_label('pdl_instruct_mode', 'singular_name'),
    'label_prerequisites'    => pdl_get_label('prerequisites'),
    'label_department'       => pdl_get_taxonomy_label('pdl_department', 'singular_name'),
    'label_college'          => pdl_get_taxonomy_label('pdl_college', 'singular_name'),
    'label_yes'              => pdl_get_label('yes'),
    'label_no'               => pdl_get_label('no'),
    'wrapper_class'          => 'pdl-meta-group',
    'meta_before_fmt'        => '<span class="%s pdl-meta-group__item"><span class="label">%s<span class="separator">:</span></span> <span class="value">',
    'terms_separator'        => ', ',
    'meta_after'             => '</span></span>',
];

$args = pdl_parse_template_args($args, $defaults, $template);

$classes = [
    'program-meta',
    esc_attr($args['wrapper_class'])
];

printf('<div class="%s">', implode(' ', $classes));

if ($args['show_instruction_mode'] && taxonomy_exists('pdl_instruct_mode')) :
    echo pdl_get_the_term_list(
        $post->ID,
        'pdl_instruct_mode',
        sprintf($args['meta_before_fmt'], 'instruction-mode', $args['label_instruction_mode']),
        $args['terms_separator'],
        $args['meta_after'],
        $args['link_terms']
    );
endif;

if ($args['show_prerequisites']) :
    printf($args['meta_before_fmt'], 'prerequisites', esc_html($args['label_prerequisites']));
    echo esc_html(get_field('prerequisites', $post) ? $args['label_yes'] : $args['label_no']);
    echo $args['meta_after'];
endif;

if ($args['show_college'] && taxonomy_exists('pdl_college')) :
    echo pdl_get_the_term_list(
        $post->ID,
        'pdl_college',
        sprintf($args['meta_before_fmt'], 'program-college', $args['label_college']),
        $args['terms_separator'],
        $args['meta_after'],
        $args['link_terms']
    );
endif;

if ($args['show_department'] && taxonomy_exists('pdl_department')) :
    echo pdl_get_the_term_list(
        $post->ID,
        'pdl_department',
        sprintf($args['meta_before_fmt'], 'department', $args['label_department']),
        $args['terms_separator'],
        $args['meta_after'],
        $args['link_terms']
    );
endif;

echo '</div>';
