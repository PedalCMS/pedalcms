<?php

$classes = [
    'action-list'
];

$classes[] = $args['wrapper_class'] ?? '';

if (!empty($args['actions'])) : ?>
<div
    class="<?php echo esc_attr(implode(' ', $classes));?>">
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
