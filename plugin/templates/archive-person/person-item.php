<?php
/**
 * Displays a single Person item, for use in an archive or other Course list.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'show_contact_info'        => true,
    'show_contact_info_labels' => false,
    'show_image'               => true,
    'link_terms'               => true,
    'img_size'                 => 'medium',
    'h_level'                  => 2,
];

$args = nvis_parse_template_args($args, $defaults, $template);
$h_tag = nvis_get_heading_tag($args['h_level']);

if ($post) :?>
<article <?php post_class('', $post); ?>>
    <?php
    if ($args['show_image']) :
        pdl_get_template_part('single-person/featured-image', ['post' => $post, 'img_size' => $args['img_size']]);
    endif;
    ?>
    <div class="person-info">
        <header>
            <?php printf('<%s class="person-name">', $h_tag); ?>
            <a href="<?php echo get_the_permalink($post); ?>"><?php echo get_the_title($post); ?></a>
            <?php printf('</%s>', $h_tag); ?>
            <div class="person-position">
                <?php pdl_get_template_part('blocks/job-title', ['job_title' => $post->job_title]); ?>
                <?php
                if (taxonomy_exists('nvis_department')) :
                    echo
                        nvis_get_the_term_list(
                            $post,
                            'nvis_department',
                            '<div class="person-department">',
                            ', ',
                            '</div>',
                            $args['link_terms']
                        );
                endif;
                ?>
            </div>
        </header>
        <?php
        if ($args['show_contact_info']) :
            pdl_get_template_part('blocks/contact-info', ['post' => $post, 'show_labels' => $args['show_contact_info_labels']]);
        endif;
        ?>
    </div>
</article>
<?php endif;
