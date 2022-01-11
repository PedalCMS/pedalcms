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
    'label_credit'       => 'credit',
    'label_credits'      => 'credits',
    'label_offered_in'   => 'Offered in',
    'label_more_details' => 'More Details'
];

$args = wp_parse_args($args, $defaults);

$more_details_id = "show-hide-" . $post->ID;

if ($post) :?>
<article <?php post_class('', $post); ?>>
    <header>
        <h2 class="entry-title">
            <a href="<?php echo get_the_permalink($post); ?>">
                <?php if ($post->course_code): ?>
                <span class="course-code"><?php echo esc_html($post->course_code); ?></span>
                <span class="separator">–</span>
                <?php endif; ?>
                <span class="course-title"><?php echo get_the_title($post); ?></span>
            </a>
        </h2>
        <div class="course-meta">
            <div class="course-credits">
                <?php
                    echo (int) $post->credits . ' ';
                    echo $post->credits === 1 ?
                        esc_html($args['label_credit']) :
                        esc_html($args['label_credits']);
                ?>
            </div>

            <?php
            $terms = get_the_terms($post, 'nvis_session');

            if (!is_wp_error($terms) && !empty($terms)) :
            ?>
            <div class="course-terms-offered">
                <?php
                echo esc_html($args['label_offered_in']);
                echo ' ';
                echo implode(', ', wp_list_pluck($terms, 'name'));
                ?>
            </div>
            <?php endif; ?>
        </div>
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
