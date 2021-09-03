<?php

namespace InvisibleUs\Programs;

add_action('init', __NAMESPACE__ . '\register_content_model');
add_action('enter_title_here', __NAMESPACE__ . '\update_enter_title_text', PHP_INT_MAX, 2);
add_action('pre_get_posts', __NAMESPACE__ . '\update_sort_order');


function register_content_model() {
    // Register post types.
    (new Program())->register();
    (new Course())->register();
    (new FAQ())->register();
    (new Person())->register();
    // Register taxonomies.
    (new ProgramType())->register();
    (new College())->register();
    (new DeliveryFormat())->register();
    (new FAQCategory())->register();
}

function update_enter_title_text(string $text, \WP_Post $post): string {
    switch ($post->post_type) {
    case 'nvis_faq':
      return 'Enter the Question';
    case 'nvis_person':
      return 'Enter the Full Name';
    default:
      return $text;

  }
}

function update_sort_order(\WP_Query $query) {
    if (is_post_type_archive('nvis_program')) {
        $query->set('order', 'ASC');
        $query->set('orderby', 'title');
    }
};

function group_faqs_by_category(array $faqs): array {
    // $cats = [];

    // foreach ($faqs as $faq) {
    //     $terms = get_the_terms($faq, 'nvis_faq_cat');

    //     if (is_array($terms)) {
    //         $cat = array_shift($terms);

    //         if (!isset($cats[$cat->slug])) {
    //             $cat->faqs = [];
    //             $cats[ $cat->slug ] = $cat;
    //         }

    //         $cats[$cat->slug]->faqs[] = $faq;
    //     }
    // }

    // return $cats;
    return FAQ::group_by_category($faqs);
}
