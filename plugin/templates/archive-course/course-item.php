<?php
/**
 * Displays a single Course item, for use in an archive or other Course list.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);
$defaults = [
    'label_more_details' => nvis_prog_get_label('more_details'),
    'label_permalink'    => nvis_get_post_type_label('nvis_course', 'view_item'),
    'label_show'         => nvis_prog_get_label('show'),
    'label_hide'         => nvis_prog_get_label('hide'),
];

$args = nvis_parse_template_args($args, $defaults, $template);

$more_details_id = "more-details-" . $post->ID;

if ($post) :?>
<article <?php post_class('', $post); ?>>
    <header>
        <h2 class="entry-title course-title">
            <a href="<?php echo get_the_permalink($post); ?>">
                <?php echo nvis_prog_get_full_course_title($post); ?>
            </a>
        </h2>
        <?php nvis_prog_get_template_part('single-course/course-meta', compact('post')); ?>
    </header>
    <div class="course-content">
        <button class="nvis-toggle__trigger --show-hide__label" aria-expanded="false"
            data-target="<?php echo $more_details_id; ?>"
            data-show-label="<?php echo esc_attr($args['label_show']); ?> "
            data-hide-label="<?php echo esc_attr($args['label_hide']); ?> "><?php echo esc_html($args['label_more_details']); ?></button>
        <div id="<?php echo $more_details_id; ?>"
            class="--show-hide__content nvis-toggle__content" hidden>
            <div class="course-details">
                <p class="course-description"><?php echo esc_html($post->short_description); ?>
                </p>

                <?php
                nvis_prog_get_template_part(
    'single-course/related-personnel',
    [
        'post'    => $post,
        'h_level' => 3,
        'style'   => 'links',
    ]
); ?>
            </div>
        </div>
    </div>
    <?php
    nvis_prog_get_template_part(
    'single-course/course-actions',
    [
        'post'            => $post,
        'add_permalink'   => true,
        'label_permalink' => $args['label_permalink']
    ]
); ?>
</article>
<?php endif;
