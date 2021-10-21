<?php
/**
 * Displays a single Course item, for use in an archive or other Course list.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = $data['post'] ?? null;

if ($post) :?>
<article <?php post_class('', $post); ?>>
    <header>
        <h2 class="course-name"><a
                href="<?php echo get_the_permalink($post); ?>"><?php echo get_the_title($post); ?></a></h2>
    </header>
    <?php
    $terms = get_the_terms($post, 'nvis_semester');

    if (!is_wp_error($terms) && !empty($terms)) :
    ?>
    <div class="course-terms-offered">
        Terms offered:
        <?php echo implode(', ', wp_list_pluck($terms, 'name')); ?>
    </div>
    <?php endif; ?>

    <?php
    $terms = get_the_terms($post, 'nvis_subject');

    if (!is_wp_error($terms) && !empty($terms)) :
    ?>
    <div class="course-subject">
        Subject:
        <?php echo implode(', ', wp_list_pluck($terms, 'name')); ?>
    </div>
    <?php endif; ?>

    <div class="course-credits">
        Credits: <?php echo (int) $post->credits; ?>
    </div>
</article>
<?php endif;
