<?php

namespace InvisibleUs\Programs;

// Breadcrumb NavXT support.
add_action('bcn_before_fill', __NAMESPACE__ . '\navxt_add_subpage');
add_action('bcn_after_fill', __NAMESPACE__ . '\navxt_replace_archive_trail');
add_filter('bcn_breadcrumb_linked', __NAMESPACE__ . '\navxt_breadcrumb_linked', 10, 3);

// Yoast SEO Breadcrumb support.
add_filter('wpseo_breadcrumb_links', __NAMESPACE__ . '\yoast_update_trail');

// All in One SEO Breadcrumb support.
add_filter('aioseo_breadcrumbs_trail', __NAMESPACE__ . '\aioseo_update_trail');

function get_programs_archive_crumb(): array {
  return [
    'text' => 'Programs',
    'url' => get_post_type_archive_link('nvis_program')
  ];
}

function get_program_subpage_crumb(): array {
  $subpage = nvis_prog_get_active_subpage();
  return [
    'text' => (nvis_prog_get_subpages())[$subpage],
    'url' => nvis_prog_subpage_link($subpage, false)
  ];
}

function navxt_add_subpage(object $trail) {
  if (is_singular('nvis_program')) {
    $crumb = get_program_subpage_crumb();
    $linked = (bool) $trail->opt['bcurrent_item_linked'];
    $trail->add(new \bcn_breadcrumb($crumb['text'], null, [], $crumb['url'], null, $linked));
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

function yoast_update_trail(array $crumbs): array
{
  if (is_singular('nvis_program')) {
    return yoast_add_subpage($crumbs);
  }

  if (nvis_prog_is_filtered_results()) {
    return yoast_replace_trail($crumbs);
  }

  return $crumbs;
}

function yoast_add_subpage(array $crumbs): array
{
  $crumbs[] = get_program_subpage_crumb();

  return $crumbs;
}

function yoast_replace_trail(array $crumbs): array {
  $home = array_shift($crumbs);

  return [
    $home,
    get_programs_archive_crumb(),
    ['text' => 'Filtered Results', 'url' => null]
  ];
}

function aioseo_update_trail(array $crumbs): array {
  if (is_singular('nvis_program')) {
    return aioseo_add_subpage($crumbs);
  }

  if (nvis_prog_is_filtered_results()) {
    return aioseo_replace_trail($crumbs);
  }

  return $crumbs;
}

function aioseo_add_subpage(array $crumbs): array
{
  $crumb = get_program_subpage_crumb();
  $crumbs[] = [
    'label' => $crumb['text'],
    'link' => $crumb['url'],
  ];

  return $crumbs;
}

function aioseo_replace_trail(array $crumbs): array
{
  $home = array_shift($crumbs);
  $crumb = get_programs_archive_crumb();

  return [
    $home,
    [
      'label' => $crumb['text'],
      'link' => $crumb['url'],
    ],
    ['label' => 'Filtered Results', 'link' => 'null']
  ];
}
