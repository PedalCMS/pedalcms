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
    'label_more_details' => 'More Details'
];

$args = wp_parse_args($args, $defaults);

$more_details_id = "show-hide-" . $post->ID;

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
    <input class="show-hide__trigger" type="checkbox"
        id="<?php echo $more_details_id; ?>">
    <label class="show-hide__label"
        for="<?php echo $more_details_id; ?>" data-show-label="Show "
        data-hide-label="Hide "><?php echo esc_html($args['label_more_details']); ?></label>
    <div class="show-hide__content">
        <div class="course-details">
            <p class="course-description"><?php echo esc_html($post->short_description); ?>
            </p>

            <?php nvis_prog_get_template_part('single-course/related-personnel', ['post' => $post, 'h_level' => 3]); ?>
        </div>
    </div>
</article>
<?php endif;
