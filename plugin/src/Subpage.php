<?php

namespace InvisibleUs\Programs;

/**
 * Manages config of each subpage.
 * 
 * @package NVISPrograms
 * @subpackage Subpages
 * @since 0.1.0
 */
class Subpage {
    public string $slug = '';
    public string $title = '';
    public string $tab_label = '';
    public string $breadcrumb_label = '';
    public string $aria_label = '';
    public int $order = 0;
    private bool $builtin = false;

    public array $fields = [];

    public function __construct(string $slug, array $args) {
        $this->slug = sanitize_title($slug, '', 'save');
        $this->title = $args['title'] ?? $this->unslugify($slug);
        $this->tab_label = $args['tab_label'] ?? $this->title;
        $this->breadcrumb_label = $args['breadcrumb_label'] ?? $this->title;
        $this->aria_label = $args['aria_label'] ?? $this->title;
        $this->order = $args['order'] ?? 1000;
        $this->builtin = $args['builtin'] ?? false;
        $this->fields = $args['fields'] ?? [];
    }

    public function is_builtin(): bool {
        return $this->builtin;
    }

    private function unslugify($string) {
        return ucwords(
            str_replace(
                ['-','_'], 
                ' ',
                $string
            )
        );
    }
}
