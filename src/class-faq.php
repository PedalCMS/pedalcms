<?php

namespace PedalCMS\Core;

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
	public const POST_TYPE = 'pdl_faq';

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
		self::$enter_title_text = __( 'Enter the Question', 'pedalcms' );

		$this->args['labels'] = [
			'name'                     => _x( 'FAQs', 'post type general name', 'pedalcms' ),
			'singular_name'            => _x( 'FAQ', 'post type singular name', 'pedalcms' ),
			'add_new_item'             => __( 'Add New FAQ', 'pedalcms' ),
			'edit_item'                => __( 'Edit FAQ', 'pedalcms' ),
			'new_item'                 => __( 'New FAQ', 'pedalcms' ),
			'view_item'                => __( 'View FAQ', 'pedalcms' ),
			'view_items'               => __( 'View FAQs', 'pedalcms' ),
			'search_items'             => __( 'Search FAQs', 'pedalcms' ),
			'not_found'                => __( 'No FAQs found.', 'pedalcms' ),
			'not_found_in_trash'       => __( 'No FAQs found in Trash.', 'pedalcms' ),
			'parent_item_colon'        => __( 'Parent FAQ:', 'pedalcms' ),
			'all_items'                => __( 'All FAQs', 'pedalcms' ),
			'archives'                 => __( 'FAQ Archives', 'pedalcms' ),
			'attributes'               => __( 'FAQ Attributes', 'pedalcms' ),
			'insert_into_item'         => __( 'Insert into FAQ', 'pedalcms' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this FAQ', 'pedalcms' ),
			'filter_items_list'        => __( 'Filter FAQs list', 'pedalcms' ),
			'items_list_navigation'    => __( 'FAQs list navigation', 'pedalcms' ),
			'items_list'               => __( 'FAQs list', 'pedalcms' ),
			'item_published'           => __( 'FAQ published.', 'pedalcms' ),
			'item_published_privately' => __( 'FAQ published privately.', 'pedalcms' ),
			'item_reverted_to_draft'   => __( 'FAQ reverted to draft.', 'pedalcms' ),
			'item_scheduled'           => __( 'FAQ scheduled.', 'pedalcms' ),
			'item_updated'             => __( 'FAQ updated.', 'pedalcms' ),
			'item_link'                => _x( 'FAQ Link', 'navigation link block title', 'pedalcms' ),
			'item_link_description'    => _x( 'A link to an FAQ.', 'navigation link block description', 'pedalcms' ),
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
			if ( $faq['faq_type'] === 'global' ) {
				$post = $faq['faq_post'];
				$cat  = get_the_terms( $post, FAQCategory::TAXONOMY );

				if ( is_array( $cat ) ) {
					$cat = $cat[0];
				} else {
					$cat = null;
				}

				$faq = [
					'question'     => $post->post_title,
					'answer'       => apply_filters( 'the_content', $post->post_content ),
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
				$term = $faq['faq_category'];
				unset( $faq['faq_category'] );

				if ( ! $term || is_wp_error( $term ) ) {
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
