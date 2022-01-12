<?php
/**
 * The template for displaying the single Course page header.
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
];

$args = wp_parse_args($args, $defaults);

?>
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