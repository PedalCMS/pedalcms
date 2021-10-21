<?php
/**
 * Displays a single Person item, for use in an archive or other Course list.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = $data['post'] ?? null;
$img_size = $data['img_size'] ?? 'medium';
$h_level = $data['h_level'] ?? 2;
$h_tag = 'h' . (int) $h_level;

if ($post) :?>
<article <?php post_class('', $post); ?>>
    <?php nvis_prog_get_template_part('single-person/featured-image', compact('post', 'img_size')); ?>
    <div class="person-info">
        <header>
            <?php echo sprintf('<%s class="person-name">', $h_tag); ?>
            <a href="<?php echo get_the_permalink($post); ?>"><?php echo get_the_title($post); ?></a>
            <?php echo sprintf('</%s>', $h_tag); ?>
        </header>
        <div class="person-position">
            <?php nvis_prog_get_template_part('blocks/job-title', ['job_title' => $post->job_title]); ?>
            <?php
            // TODO: Link these somewhere else?
            the_terms(
                $post,
                'nvis_department',
                '<div class="person-department">',
                ', ',
                '</div>'
            ); ?>
        </div>
        <?php nvis_prog_get_template_part('blocks/contact-info', compact('post')); ?>
    </div>
</article>
<?php endif;
