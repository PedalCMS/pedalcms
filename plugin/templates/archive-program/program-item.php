<?php
/**
 * Displays a single Program item, for use in an archive or other Program list.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = $args['post'] ?? null;

if ($post) :?>
<article <?php post_class('', $post); ?>>

    <?php if (has_post_thumbnail($post)):?>
    <div class="program-featured-image">
        <?php echo get_the_post_thumbnail($post, 'medium'); ?>
    </div>
    <?php endif; ?>

    <div class="program-info">
        <header>
            <h2 class="program-title"><a
                    href="<?php echo get_the_permalink($post); ?>"><?php echo get_the_title($post); ?></a></h2>
            <?php the_terms($post, 'nvis_program_type'); ?>
        </header>
        <?php nvis_prog_get_template_part('archive-program/program-meta', compact('post')); ?>
    </div>
    <?php
                $add_permalink = get_permalink($post);
                nvis_prog_get_template_part('single-program/program-actions', compact('add_permalink'));
            ?>
</article>
<?php endif;
