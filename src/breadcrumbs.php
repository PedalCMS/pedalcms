<?php

namespace InvisibleUs\Programs;

// Breadcrumb NavXT support.
add_action('bcn_before_fill', __NAMESPACE__ . '\navxt_add_subpage');
add_action('bcn_after_fill', __NAMESPACE__ . '\navxt_replace_archive_trail');
add_filter('bcn_breadcrumb_linked', __NAMESPACE__ . '\navxt_breadcrumb_linked', 10, 3);

// Yoast SEO Breadcrumb support.
add_filter('wpseo_breadcrumb_links', __NAMESPACE__ . '\yoast_add_subpage');

// All in One SEO Breadcrumb support.
add_filter('aioseo_breadcrumbs_trail', __NAMESPACE__ . '\aioseo_add_subpage');

function get_programs_archive_crumb(): array {
  return [
    'text' => 'Programs',
    'url' => get_post_type_archive_link( 'nvis_program' )
  ];
}

function navxt_add_subpage(object $trail) {
  if (is_singular('nvis_program')) {
    $subpage = nvis_prog_get_active_subpage();
    $title = (nvis_prog_get_subpages())[$subpage];
    // TODO: Add support for "Link Current Item" feature.
    $trail->add(new \bcn_breadcrumb($title, null, [], null, null, false));
  }
}

function navxt_replace_archive_trail(object $trail) {
  if (nvis_prog_is_filtered_results()) {
    if ($trail->opt['bhome_display']) {
      $home = array_pop($trail->breadcrumbs);
    } 
    $trail->breadcrumbs = [];
    $crumb = get_programs_archive_crumb();
    
    $trail->add(new \bcn_breadcrumb('Filtered Results', null, [], null, null, false));
    $trail->add(new \bcn_breadcrumb($crumb['text'], null, [], $crumb['url'], null, true));

    if ($trail->opt['bhome_display']) {
      $trail->breadcrumbs[] = $home;
    } 
  }
}

function navxt_breadcrumb_linked(bool $linked, array $types, int $id = null): bool
{
  if (is_singular('nvis_program') && in_array('post-nvis_program', $types)) {
    // TODO: Add support for "Link Current Item" feature.
    // ID is null for newly created subpages.
    return (bool) $id;
  }
  return $linked;
}

function yoast_add_subpage(array $crumbs): array
{
  global $post;

  if (is_singular('nvis_program')) {
    $subpage = nvis_prog_get_active_subpage();
    $title = (nvis_prog_get_subpages())[$subpage];

    $crumbs[] = [
      'text' => $title,
      'url' => nvis_prog_subpage_link($subpage, false),
    ];
  }

  return $crumbs;
}

function aioseo_add_subpage(array $crumbs): array
{
  global $post;

  if (is_singular('nvis_program')) {
    $subpage = nvis_prog_get_active_subpage();
    $title = (nvis_prog_get_subpages())[$subpage];
    // error_log(print_r($crumbs, true));
    $crumbs[] = [
      'label' => $title,
      'link' => nvis_prog_subpage_link($subpage, false),
    ];
  }

  return $crumbs;
}
