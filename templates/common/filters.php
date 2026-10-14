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

$pedalcms_defaults = [
	'post_type'                  => null,
	'wrapper_class'              => '',
	'break_filters_after'        => 0,
	'label_filter'               => pedalcms_get_label( 'filter_your_search' ),
	'label_show'                 => pedalcms_get_label( 'show' ),
	'label_hide'                 => pedalcms_get_label( 'hide' ),
	'label_more_filters'         => pedalcms_get_label( 'more_filters' ),
	'label_apply_filters'        => pedalcms_get_label( 'apply_filters' ),
	'label_reset_filters'        => pedalcms_get_label( 'reset_filters' ),
	'label_missing_filters_data' => pedalcms_get_label( 'missing_filters_data' ),
	'icon_search'                => pedalcms_get_icon(
		'magnifying-glass',
		[
			'size'  => 20,
			'class' => 'pdl-icon--md normal',
		]
	),
	'icon_loading'               => pedalcms_get_icon(
		'arrow-path',
		[
			'size'  => 20,
			'class' => 'pdl-icon--md loading',
		]
	),
	'icon_reset'                 => pedalcms_get_icon(
		'x-circle',
		[
			'size'  => 20,
			'class' => 'pdl-icon--md',
		]
	),
	'filters'                    => [ 'keyword' ],
];

$pedalcms_args = pedalcms_parse_template_args( $args, $pedalcms_defaults, $template );

$pedalcms_form_id      = 'search-filter-form';
$pedalcms_form_action  = sprintf(
	'%s#%s',
	get_post_type_archive_link( $pedalcms_args['post_type'] ),
	'post-list'
);
$pedalcms_form_class   = pedalcms_get_html_class_attr(
	'pdl-post-filters',
	'pdl-post-filters-' . count( $pedalcms_args['filters'] ),
	$pedalcms_args['post_type'] . '-filters',
	$pedalcms_args['wrapper_class']
);
$pedalcms_reset_link   = sprintf(
	'%s#%s',
	get_post_type_archive_link( $pedalcms_args['post_type'] ),
	$pedalcms_form_id
);
$pedalcms_reset_active = pedalcms_is_filtered_results( $pedalcms_args['post_type'] ) ||
	is_tax( get_object_taxonomies( $pedalcms_args['post_type'] ) );
$pedalcms_reset_class  = pedalcms_get_html_class_attr(
	'reset-link',
	$pedalcms_reset_active ? 'reset-link--active' : 'reset-link--inactive'
);
$pedalcms_reset_text   = sprintf(
	'%s<span class="link-text">%s</span>',
	$pedalcms_args['icon_reset'],
	$pedalcms_args['label_reset_filters']
);

if ( ! empty( $pedalcms_args['filters'] ) && ! empty( $pedalcms_args['post_type'] ) ) : ?>
<form id="<?php echo esc_attr( $pedalcms_form_id ); ?>" action="<?php echo esc_url( $pedalcms_form_action ); ?>" class="<?php echo esc_attr( $pedalcms_form_class ); ?>">
	<fieldset>
		<legend class="screen-reader-text"><?php echo esc_html( $pedalcms_args['label_filter'] ); ?>
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
			do_action( 'pedalcms/before_filters_fields', $pedalcms_args );

			$pedalcms_show_more = false;

			foreach ( $pedalcms_args['filters'] as $pedalcms_i => $pedalcms_filter ) :
				if ( $pedalcms_args['break_filters_after'] && $pedalcms_args['break_filters_after'] === $pedalcms_i ) :
					$pedalcms_show_more = true;
					?>
			<button type="button" data-target="more-filters" class="pdl-toggle__trigger" aria-expanded="false"
				data-show-label="<?php echo esc_attr( $pedalcms_args['label_show'] ); ?> "
				data-hide-label="<?php echo esc_attr( $pedalcms_args['label_hide'] ); ?> ">
					<?php echo esc_html( $pedalcms_args['label_more_filters'] ); ?>
			</button>
			<div id="more-filters" class="more-filters pdl-toggle__content" hidden>
				<div class="more-filters__content">
					<?php
				endif;

				if ( is_array( $pedalcms_filter ) && count( $pedalcms_filter ) > 1 ) :
					pedalcms_get_template_part( 'common/filters/' . $pedalcms_filter[0], $pedalcms_filter[1] );
				elseif ( is_string( $pedalcms_filter ) ) :
					pedalcms_get_template_part( 'common/filters/' . $pedalcms_filter );
				endif;
			endforeach;

			if ( $pedalcms_show_more ) :
				echo '</div></div>';
			endif;

			/**
			 * Fires after the search filter fields are loaded.
			 *
			 * @since 0.1.0
			 *
			 * @param array $args The args passed to the template: a list of filters and the post_type.
			 */
			do_action( 'pedalcms/after_filters_fields', $pedalcms_args );
			?>
		</div>
		<input type="hidden" name="post_type" value="<?php echo esc_attr( $pedalcms_args['post_type'] ); ?>">
	</fieldset>
	<div class="actions">
		<button class="search-button button" type="submit">
			<?php echo wp_kses( $pedalcms_args['icon_search'] . $pedalcms_args['icon_loading'], pedalcms_kses_svg() ); ?>
			<span class="action-text"><?php echo esc_html( $pedalcms_args['label_apply_filters'] ); ?></span>
		</button>


		<?php if ( $pedalcms_reset_active ) : ?>
		<a class="<?php echo esc_attr( $pedalcms_reset_class ); ?>" href="<?php echo esc_url( $pedalcms_reset_link ); ?>"><?php echo wp_kses( $pedalcms_reset_text, pedalcms_kses_svg() ); ?></a>
		<?php endif; ?>
	</div>
</form>
	<?php
endif;
