<?php
/**
 * The template for displaying Program meta items, for use on single Program.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'show_college'           => true,
    'show_department'        => true,
    'show_instruction_mode'  => true,
    'show_prerequisites'     => true,
    'link_terms'             => true,
    'label_instruction_mode' => nvis_get_taxonomy_label('nvis_instruct_mode', 'singular_name'),
    'label_prerequisites'    => nvis_prog_get_label('prerequisites'),
    'label_department'       => nvis_get_taxonomy_label('nvis_department', 'singular_name'),
    'label_college'          => nvis_get_taxonomy_label('nvis_college', 'singular_name'),
    'label_yes'              => nvis_prog_get_label('yes'),
    'label_no'               => nvis_prog_get_label('no'),
    'wrapper_class'          => 'nvis-meta-group',
    'meta_before_fmt'        => '<span class="%s nvis-meta-group__item"><span class="label">%s<span class="separator">:</span></span> <span class="value">',
    'terms_separator'        => ', ',
    'meta_after'             => '</span></span>',
];

$args = nvis_parse_template_args($args, $defaults, $template);

$classes = [
    'program-meta',
    esc_attr($args['wrapper_class'])
];

echo sprintf('<div class="%s">', implode(' ', $classes));

if ($args['show_instruction_mode'] && taxonomy_exists('nvis_instruct_mode')) :
    echo nvis_get_the_term_list(
        $post->ID,
        'nvis_instruct_mode',
        sprintf($args['meta_before_fmt'], 'instruction-mode', $args['label_instruction_mode']),
        $args['terms_separator'],
        $args['meta_after'],
        $args['link_terms']
    );
endif;

if ($args['show_prerequisites']) :
    echo sprintf($args['meta_before_fmt'], 'prerequisites', esc_html($args['label_prerequisites']));
    echo esc_html(get_field('prerequisites', $post) ? $args['label_yes'] : $args['label_no']);
    echo $args['meta_after'];
endif;

if ($args['show_college'] && taxonomy_exists('nvis_college')) :
    echo nvis_get_the_term_list(
        $post->ID,
        'nvis_college',
        sprintf($args['meta_before_fmt'], 'program-college', $args['label_college']),
        $args['terms_separator'],
        $args['meta_after'],
        $args['link_terms']
    );
endif;

if ($args['show_department'] && taxonomy_exists('nvis_department')) :
    echo nvis_get_the_term_list(
        $post->ID,
        'nvis_department',
        sprintf($args['meta_before_fmt'], 'department', $args['label_department']),
        $args['terms_separator'],
        $args['meta_after'],
        $args['link_terms']
    );
endif;

echo '</div>';
