<?php

namespace PedalCMS\Core;

defined( 'ABSPATH' ) || exit;

/**
 * FAQ custom post type.
 *
 * @package PedalCMS\Core\ContentModel
 * @since 0.1.0
 */
class FAQ extends CustomPostType {
	/**
	 * @inheritdoc
	 */
	public const POST_TYPE = 'pedalcms_faq';

	/**
	 * @inheritdoc
	 */
	public static string $enter_title_text = '';

	/**
	 * @inheritdoc
	 */
	public array $args = [
		'rewrite'         => [ 'slug' => 'faq' ],
		'has_archive'     => 'faqs',
		'capability_type' => self::POST_TYPE,
		'menu_icon'       => '',
		'menu_position'   => 5,
		'description'     => '',
		'public'          => true,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'query_var'       => true,
		'map_meta_cap'    => true,
		'hierarchical'    => false,
		'supports'        => [ 'title', 'editor' ],
	];

	/**
	 * @inheritdoc
	 */
	protected function setup_labels(): void {
		static::$enter_title_text = __( 'Enter the Question', 'pedal-cms' );

		$this->args['labels'] = [
			'name'                     => _x( 'FAQs', 'post type general name', 'pedal-cms' ),
			'singular_name'            => _x( 'FAQ', 'post type singular name', 'pedal-cms' ),
			'add_new_item'             => __( 'Add New FAQ', 'pedal-cms' ),
			'edit_item'                => __( 'Edit FAQ', 'pedal-cms' ),
			'new_item'                 => __( 'New FAQ', 'pedal-cms' ),
			'view_item'                => __( 'View FAQ', 'pedal-cms' ),
			'view_items'               => __( 'View FAQs', 'pedal-cms' ),
			'search_items'             => __( 'Search FAQs', 'pedal-cms' ),
			'not_found'                => __( 'No FAQs found.', 'pedal-cms' ),
			'not_found_in_trash'       => __( 'No FAQs found in Trash.', 'pedal-cms' ),
			'parent_item_colon'        => __( 'Parent FAQ:', 'pedal-cms' ),
			'all_items'                => __( 'All FAQs', 'pedal-cms' ),
			'archives'                 => __( 'FAQ Archives', 'pedal-cms' ),
			'attributes'               => __( 'FAQ Attributes', 'pedal-cms' ),
			'insert_into_item'         => __( 'Insert into FAQ', 'pedal-cms' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this FAQ', 'pedal-cms' ),
			'filter_items_list'        => __( 'Filter FAQs list', 'pedal-cms' ),
			'items_list_navigation'    => __( 'FAQs list navigation', 'pedal-cms' ),
			'items_list'               => __( 'FAQs list', 'pedal-cms' ),
			'item_published'           => __( 'FAQ published.', 'pedal-cms' ),
			'item_published_privately' => __( 'FAQ published privately.', 'pedal-cms' ),
			'item_reverted_to_draft'   => __( 'FAQ reverted to draft.', 'pedal-cms' ),
			'item_scheduled'           => __( 'FAQ scheduled.', 'pedal-cms' ),
			'item_updated'             => __( 'FAQ updated.', 'pedal-cms' ),
			'item_link'                => _x( 'FAQ Link', 'navigation link block title', 'pedal-cms' ),
			'item_link_description'    => _x( 'A link to an FAQ.', 'navigation link block description', 'pedal-cms' ),
		];
	}

	/**
	 * Takes a list of FAQs and returns them indexed by category.
	 *
	 * @param array $faqs A list of FAQs of the type WP_Post.
	 * @return array The category indexed list of FAQs.
	 */
	public static function group_by_category( array $faqs ): array {
		return self::group_by_tax( $faqs, FAQCategory::TAXONOMY, 'faqs' );
	}

	/**
	 * Normalizes a list of FAQs of mixed type.
	 *
	 * @param array $faqs A list of FAQs of mixed type WP_Post.
	 * @param bool $group_by_cat Group by FAQCategory?
	 * @return array The list of FAQs, either grouped by category or not.
	 */
	public static function normalize_faq_types( array $faqs, bool $group_by_cat = false ): array {
		$new_list = [];

		foreach ( $faqs as $faq ) {
			if ( 'global' === $faq['faq_type'] ) {
				if ( empty( $faq['faq_post'] ) ) {
					continue;
				}

				$post = get_post( $faq['faq_post'][0] );

				if ( ! ( $post instanceof \WP_Post ) ) {
					continue;
				}

				$cat = get_the_terms( $post, FAQCategory::TAXONOMY );

				if ( is_array( $cat ) ) {
					$cat = $cat[0];
				} else {
					$cat = null;
				}

				$faq = [
					'question'     => $post->post_title,
					'answer'       => apply_filters( 'the_content', $post->post_content ), // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Core hook.
					'faq_category' => $cat,
				];
			} else {
				unset( $faq['faq_post'] );
			}

			unset( $faq['faq_type'] );
			$new_list[] = $faq;
		}

		if ( $group_by_cat ) {
			$groups = [];
			// TODO: Filter this.
			$uncat_term = (object) [
				'slug' => 'uncategorized',
				'name' => 'Uncategorized',
				'faqs' => [],
			];

			foreach ( $new_list as $faq ) {
				$term = get_term( $faq['faq_category'] );
				unset( $faq['faq_category'] );

				if ( ! $term instanceof \WP_Term ) {
					$term = $uncat_term;
				}

				if ( ! isset( $groups[ $term->slug ] ) ) {
					$term->faqs            = [];
					$groups[ $term->slug ] = $term;
				}
				$groups[ $term->slug ]->faqs[] = $faq;
			}

			$new_list = $groups;
		}

		return $new_list;
	}
}
