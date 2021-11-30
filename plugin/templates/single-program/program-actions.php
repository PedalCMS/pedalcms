<?php
/**
 * The template for displaying Program action buttons.
 *
 * @package NVISPrograms
 * @subpackage Templates
 * @version 1.0
 */

defined('ABSPATH') || exit;

$post = nvis_args_or_global('post', $args);

$defaults = [
    'add_permalink' => false,
    'actions'       => [
        [
            'label' => 'Apply Now',
            'url'   => nvis_prog_get_action_link('apply_now', $post),
            'class' => 'apply-now'
        ],
        [
            'label' => 'Request Info',
            'url'   => nvis_prog_get_action_link('request_info', $post),
            'class' => 'request-info'
        ]
    ]
];

$args = wp_parse_args($args, $defaults);

if ($args['add_permalink']) {
    $permalink = $permalink === true ? get_permalink($post) : $permalink;

    array_unshift(
        $args['actions'],
        [
            'label' => 'Program Details',
            'url'   => $permalink,
            'class' => 'program-details'
        ]
    );
}

if (!empty($args['actions'])) : ?>
<div class="program-actions">
  <ul>
    <?php
    foreach ($args['actions'] as $i => $action) :
      $class = $action['class'] ?? '';
      $class .= ' button ';
      $class .= $i ? 'button-secondary' : 'button-primary';

      echo sprintf(
          '<li><a class="%s" href="%s">%s</a></li>',
          esc_attr($class),
          esc_url($action['url']),
          esc_html($action['label'])
      );
    endforeach;
    ?>
  </ul>
</div>
<?php endif;
