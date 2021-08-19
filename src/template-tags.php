<?php

function nvis_prog_get_template_part(string $template, array $data = [])
{
  \InvisibleUs\Programs\TemplateManager::loadTemplate($template, $data);
}

function nvis_prog_has_news(): bool {
  // TODO: Make this work.
  return false;
}

function nvis_prog_show_subpages(): bool {
  // TODO: Make this work. 
  return true;
}

function nvis_prog_get_subpages(): array {
  return \InvisibleUs\Programs\get_subpages();
}

function nvis_prog_get_active_subpage(): string {
  return \InvisibleUs\Programs\get_active_subpage();
}

// TODO: Move this to subpages.
function nvis_prog_show_subpage(string $subpage): bool {
  // TODO: Add Global Setting awareness.
  return $subpage === 'index' ?
    true :
    (bool) get_field(
      sprintf('show_%s_section', $subpage)
    );  
}

function nvis_prog_is_active_subpage(string $subpage): bool {
  return nvis_prog_get_active_subpage() === $subpage;
}

// TODO: Move this to subpages.
function nvis_prog_subpage_link(string $subpage, bool $echo = true): string {

  $link = $subpage === 'index' ?
    get_the_permalink() : 
    sprintf('%s%s/', get_the_permalink(), $subpage);

  if ($echo) {
    echo $link;
  }

  return $link;
}

function nvis_prog_get_action_link(string $action, mixed $program = null): string {
  $program = get_post($program);

  // Check for a local override.
  $url = get_field('url_' . $action, $program);
  if ($url) {
    return $url;
  }
  
  // Check for the global setting.
  $url = get_field('nvis_url_' . $action, 'option');
  if ($url) {
    $url = str_replace(
      ['{$program_guid}', '{$program_slug}'],
      [get_field('program_guid', $program), $program->post_name],
      $url
    );
    return $url;
  }

  return '';
}

function nvis_prog_get_faqs_by_category(array $faqs): array {
  return \InvisibleUs\Programs\group_faqs_by_category($faqs);
}
