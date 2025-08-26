<?php

/**
 * A template for displaying a search and filter form.
 *
 * @package PedalCMS\Core\Templates
 * @version 1.0
 * @since 0.1.0
 *
 */

defined( 'ABSPATH' ) || exit;

$defaults = [
	'post_type'                  => null,
	'wrapper_class'              => '',
	'break_filters_after'        => -1,
	'label_filter'               => pdl_get_label( 'filter_your_search' ),
	'label_show'                 => pdl_get_label( 'show' ),
	'label_hide'                 => pdl_get_label( 'hide' ),
	'label_more_filters'         => pdl_get_label( 'more_filters' ),
	'label_apply_filters'        => pdl_get_label( 'apply_filters' ),
	'label_reset_filters'        => pdl_get_label( 'reset_filters' ),
	'label_missing_filters_data' => pdl_get_label( 'missing_filters_data' ),
	'icon_search'                => pdl_get_icon(
		'magnifying-glass',
		[
			'size'  => 20,
			'class' => 'pdl-icon--md normal',
		]
	),
	'icon_loading'               => pdl_get_icon(
		'arrow-path',
		[
			'size'  => 20,
			'class' => 'pdl-icon--md loading',
		]
	),
	'icon_reset'                 => pdl_get_icon(
		'x-circle',
		[
			'size'  => 20,
			'class' => 'pdl-icon--md',
		]
	),
	'filters'                    => [ 'keyword' ],
];

$args = pdl_parse_template_args( $args, $defaults, $template );

$form_id      = 'search-filter-form';
$form_action  = sprintf(
	'%s#%s',
	get_post_type_archive_link( $args['post_type'] ),
	'post-list'
);
$form_class   = pdl_get_html_class_attr(
	'pdl-post-filters',
	'pdl-post-filters-' . count( $args['filters'] ),
	$args['post_type'] . '-filters',
	$args['wrapper_class']
);
$reset_link   = sprintf(
	'%s#%s',
	get_post_type_archive_link( $args['post_type'] ),
	$form_id
);
$reset_active = pdl_is_filtered_results( $args['post_type'] ) ||
	is_tax( get_object_taxonomies( $args['post_type'] ) );
$reset_class  = pdl_get_html_class_attr(
	'reset-link',
	$reset_active ? 'reset-link--active' : 'reset-link--inactive'
);
$reset_text   = sprintf(
	'%s<span class="link-text">%s</span>',
	$args['icon_reset'],
	$args['label_reset_filters']
);

if ( ! empty( $args['filters'] ) && ! empty( $args['post_type'] ) ) : ?>
<form id="<?php echo esc_attr( $form_id ); ?>" action="<?php echo esc_url( $form_action ); ?>" class="<?php echo esc_attr( $form_class ); ?>">
	<fieldset>
		<legend class="screen-reader-text"><?php echo esc_html( $args['label_filter'] ); ?>
		</legend>
		<div class="filters">
			<?php

			/**
			 * Fires before the search filter fields are loaded.
			 *
			 * @since 0.1.0
			 *
			 * @param array $args The args passed to the template: a list of filters and the post_type.
			 */
			do_action( 'pdl/before_filters_fields', $args );

			$show_more = false;

			foreach ( $args['filters'] as $i => $filter ) :
				if ( $args['break_filters_after'] && $args['break_filters_after'] === $i ) :
					$show_more = true;
					?>
			<button type="button" data-target="more-filters" class="pdl-toggle__trigger" aria-expanded="false"
				data-show-label="<?php echo esc_attr( $args['label_show'] ); ?> "
				data-hide-label="<?php echo esc_attr( $args['label_hide'] ); ?> ">
					<?php echo esc_html( $args['label_more_filters'] ); ?>
			</button>
			<div id="more-filters" class="more-filters pdl-toggle__content" hidden>
				<div class="more-filters__content">
					<?php
				endif;

				if ( is_array( $filter ) && count( $filter ) > 1 ) :
					pdl_get_template_part( 'common/filters/' . $filter[0], $filter[1] );
				elseif ( is_string( $filter ) ) :
					pdl_get_template_part( 'common/filters/' . $filter );
				endif;
			endforeach;

			if ( $show_more ) :
				echo '</div></div>';
			endif;

			/**
			 * Fires after the search filter fields are loaded.
			 *
			 * @since 0.1.0
			 *
			 * @param array $args The args passed to the template: a list of filters and the post_type.
			 */
			do_action( 'pdl/after_filters_fields', $args );
			?>
		</div>
		<input type="hidden" name="post_type" value="<?php echo esc_attr( $args['post_type'] ); ?>">
	</fieldset>
	<div class="actions">
		<button class="search-button button" type="submit">
			<?php echo wp_kses_post( $args['icon_search'] . $args['icon_loading'] ); ?>
			<span class="action-text"><?php echo esc_html( $args['label_apply_filters'] ); ?></span>
		</button>


		<?php if ( $reset_active ) : ?>
		<a class="<?php echo esc_attr( $reset_class ); ?>" href="<?php echo esc_url( $reset_link ); ?>"><?php echo wp_kses_post( $reset_text ); ?></a>
		<?php endif; ?>
	</div>
</form>
	<?php
endif;
